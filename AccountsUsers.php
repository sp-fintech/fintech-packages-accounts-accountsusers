<?php

namespace Apps\Fintech\Packages\Accounts\Users;

use System\Base\BasePackage;

class AccountsUsers extends BasePackage
{
    //protected $modelToUse = ::class;

    protected $packageName = 'accountsusers';

    public $accountsusers;

    public function getAccountsUsersById($id)
    {
        $accountsusers = $this->getById($id);

        if ($accountsusers) {
            //
            $this->addResponse('Success');

            return;
        }

        $this->addResponse('Error', 1);
    }

    public function addAccountsUsers($data)
    {
        //
    }

    public function updateAccountsUsers($data)
    {
        $accountsusers = $this->getById($id);

        if ($accountsusers) {
            //
            $this->addResponse('Success');

            return;
        }

        $this->addResponse('Error', 1);
    }

    public function removeAccountsUsers($data)
    {
        $accountsusers = $this->getById($id);

        if ($accountsusers) {
            //
            $this->addResponse('Success');

            return;
        }

        $this->addResponse('Error', 1);
    }
}