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
            $account = $this->model->toArray();

            $account['balances'] = [];
            if ($this->model->getbalances()) {
                $account['balances'] = $this->model->getsecurity()->toArray();
            }

            return $account;
        } else {
            if ($this->ffData) {
                $this->ffData = $this->jsonData($this->ffData, true);

                return $this->ffData;
            }
        }

        return null;
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
        $accountsusers = $this->getById((int) $id);

        if ($accountsusers) {
            //
            $this->addResponse('Success');

            return;
        }

        $this->addResponse('Error', 1);
    }

    public function removeAccountsUser($data)
    {
        $accountsusers = $this->getById((int) $id);

        if ($accountsusers) {
            //
            $this->addResponse('Success');

            return;
        }

        $this->addResponse('Error', 1);
    }
}