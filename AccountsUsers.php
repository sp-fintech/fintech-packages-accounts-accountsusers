<?php

namespace Apps\Fintech\Packages\Accounts\Users;

use Apps\Fintech\Packages\Accounts\Users\Model\AppsFintechAccountsUsers;
use System\Base\BasePackage;

class AccountsUsers extends BasePackage
{
    protected $modelToUse = AppsFintechAccountsUsers::class;

    protected $packageName = 'accountsusers';

    public $accountsusers;

    public function getAccountsUserById(int $id)
    {
        $this->ffStore = $this->ff->store($this->ffStoreToUse);

        $this->setFFRelations(true);

        $this->getFirst('id', $id);

        if ($this->model) {
            $user = $this->model->toArray();

            $user['balances'] = [];
            if ($this->model->getbalances()) {
                $user['balances'] = $this->model->getsecurity()->toArray();
            }
        } else {
            if ($this->ffData) {
                $user = $this->jsonData($this->ffData, true);
            }
        }

        if (isset($user)) {
            if (isset($user['balances']) && count($user['balances']) > 0) {
                $user['balances'] = msort($user['balances'], 'date');

                $userBalance = 0;
                foreach ($user['balances'] as &$balance) {
                    if ($balance['type'] === 'debit') {
                        $balance['balance'] = $userBalance = numberFormatPrecision($userBalance + $balance['amount']);
                    } else if ($balance['type'] === 'credit') {
                        $balance['balance'] = $userBalance = numberFormatPrecision($userBalance - $balance['amount']);
                    }
                }
            }

            return $user;
        }

        return false;
    }

    public function getAccountsUserByAccountId(int $account_id)
    {
        if ($this->config->databasetype === 'db') {
            $conditions =
                [
                    'conditions'    => 'account_id = :account_id:',
                    'bind'          =>
                        [
                            'account_id'       => (int) $account_id,
                        ]
                ];
        } else {
            $conditions =
                [
                    'conditions'    => ['account_id', '=', (int) $account_id]
                ];
        }

        $usersArr = $this->getByParams($conditions);

        if ($usersArr && count($usersArr) > 0) {
            $users = [];

            foreach ($usersArr as $user) {
                $user['name'] = $user['first_name'] . ' ' . $user['last_name'];

                $users[$user['id']] = $user;
            }

            return $users;
        }

        return [];
    }

    public function addAccountsUser($data)
    {
        $data['account_id'] = $this->access->auth->account()['id'];
        $data['equity_balance'] = 0.00;

        if ($this->add($data)) {
            $this->addResponse('User Added');
        } else {
            $this->addResponse('Error Adding User', 1);
        }
    }

    public function updateAccountsUser($data)
    {
        $accountsusers = $this->getById((int) $data['id']);

        if ($accountsusers) {
            $data = array_merge($accountsusers, $data);

            if ($this->update($data)) {
                $this->addResponse('User updated');

                return;
            }
        }

        $this->addResponse('Error', 1);
    }

    public function removeAccountsUser($id)
    {
        $accountsusers = $this->getById((int) $id);

        if (!$accountsusers) {
            $this->addResponse('User account with ID not found.', 1);

            return false;
        }

        //Check if user if any portfolio exists for this user.

        if ($this->remove($accountsusers['id'])) {
            //Remove users balances.
            $this->addResponse('User removed');

            return true;
        }

        $this->addResponse('Error removing user.', 1);
    }
}