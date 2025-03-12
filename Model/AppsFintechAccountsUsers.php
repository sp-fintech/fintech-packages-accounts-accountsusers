<?php

namespace Apps\Fintech\Packages\Accounts\Users\Model;

use Apps\Fintech\Packages\Accounts\Balances\Model\AppsFintechAccountsBalances;
use System\Base\BaseModel;

class AppsFintechAccountsUsers extends BaseModel
{
    protected $modelRelations = [];

    public $id;

    public $account_id;

    public $first_name;

    public $last_name;

    public $equity_balance;

    public function initialize()
    {
        $this->modelRelations['balances']['relationObj'] = $this->hasMany(
            'id',
            AppsFintechAccountsBalances::class,
            'user_id',
            [
                'alias'         => 'balances'
            ]
        );

        parent::initialize();
    }

    public function getModelRelations()
    {
        if (count($this->modelRelations) === 0) {
            $this->initialize();
        }

        return $this->modelRelations;
    }
}