<?php

namespace Apps\Fintech\Packages\Accounts\Users\Model;

use System\Base\BaseModel;

class AppsFintechAccountsUsers extends BaseModel
{
    protected $modelRelations = [];

    public $id;

    public $account_id;

    public $first_name;

    public $last_name;

    public $equity_balance;
}