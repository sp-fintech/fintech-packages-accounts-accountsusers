<?php

namespace Apps\Fintech\Packages\Accounts\Users;

use Apps\Fintech\Packages\Accounts\Users\Model\AppsFintechAccountsUsers;
use System\Base\BasePackage;

class AccountsUsers extends BasePackage
{
    protected $modelToUse = AppsFintechAccountsUsers::class;

    protected $packageName = 'accountsusers';

    public $accountsusers;

    public function addAccountsUsers($data)
    {

    }

    public function updateAccountsUsers($data)
    {
        $accountsusers = $this->getById((int) $id);

        if ($accountsusers) {
            //
            $this->addResponse('Success');

            return;
        }

        $this->addResponse('Error', 1);
    }

    public function removeAccountsUsers($data)
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