<?php


namespace App\Services;

use App\Events\UserPaid;
use App\Models\User;
use Illuminate\Http\Request;

class PayPalService
{
    /**
     * @var Request $request
     */
    private $request;

    private $debug;

    const LOG_START = 1;
    const LOG_VALIDATION_FAILED = 2;

    const TXN_TYPE = 'web_accept';


    public function __construct()
    {
        $this->debug = getenv('APP_ENV') === 'local' || getenv('APP_ENV') === 'testing';
    }

    public function process(Request $request)
    {
        $this->setRequest($request);
        $this->logging(self::LOG_START);

        if ($this->validateRequest()) {
            $this->handle();
        }
    }

    private function setRequest($request)
    {
        $this->request = $request;
    }

    private function validateRequest()
    {
        if( ! $this->checkCompleted() ||
            ! $this->checkBusiness()  ||
            ! $this->checkCurrency()  ||
            ! $this->checkTxnType() )
        {
            $this->logging(self::LOG_VALIDATION_FAILED);

            return false;
        }
        else
        {
            return true;
        }
    }

    private function handle()
    {
        event(new UserPaid(User::find($this->request->custom)));
    }

    private function checkTxnType()
    {
        return $this->request->txn_type === self::TXN_TYPE;
    }

    private function checkCompleted()
    {
        return  $this->request->payment_status === 'Completed';
    }

    private function checkBusiness()
    {
        if($this->request->test_ipn) {
            return $this->request->business === env('PAYPAL_SANDBOX_EMAIL');
        }
        else {
            return $this->request->business === env('PAYPAL_EMAIL');
        }
    }

    private function checkCurrency()
    {
        if(!$this->request->test_ipn) {
            return $this->request->mc_currency === env('PAYPAL_CURRENCY');
        }
        else {
            return $this->request->mc_currency === env('PAYPAL_SANDBOX_CURRENCY');
        }
    }

    private function log($message)
    {
        if ($this->debug) {
            \Log::info($message);
        }
    }

    private function logging($type)
    {
        switch ($type) {
            case self::LOG_START :
                $this->log('Notification start...');
                $this->log('DEBUG: ' . $this->request->getPathInfo() . ($this->request->getQueryString() ? ('?' . $this->request->getQueryString()) : ''));
                break;
            case self::LOG_VALIDATION_FAILED :
                $this->log('Validation of request is failed.');
                break;
        }
    }
}