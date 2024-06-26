<?php

namespace App\Providers;

use App\Events\ItemApproved;
use App\Events\ItemResubmitted;
use App\Events\ItemSubmitted;
use App\Events\ItemUpdated;
use App\Events\KycVerificationPending;
use App\Events\RefundAccepted;
use App\Events\Registered;
use App\Events\SaleCancelled;
use App\Events\SaleCreated;
use App\Events\SaleRefunded;
use App\Events\TicketCreated;
use App\Events\TicketReplyCreated;
use App\Events\TransactionPaid;
use App\Events\TransactionPending;
use App\Events\WithdrawalSubmitted;
use App\Listeners\ProcessAcceptedRefund;
use App\Listeners\ProcessApprovedItem;
use App\Listeners\ProcessCancelledSale;
use App\Listeners\ProcessNewSale;
use App\Listeners\ProcessPaidTransaction;
use App\Listeners\ProcessPendingKycVerification;
use App\Listeners\ProcessPendingTransaction;
use App\Listeners\ProcessReferralRegistration;
use App\Listeners\ProcessRefundedSale;
use App\Listeners\ProcessResubmittedItem;
use App\Listeners\ProcessSubmittedItem;
use App\Listeners\ProcessSubmittedWithdrawal;
use App\Listeners\ProcessTicketCreation;
use App\Listeners\ProcessTicketReplyCreation;
use App\Listeners\ProcessUpdatedItem;
use App\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class, ProcessReferralRegistration::class],
        KycVerificationPending::class => [ProcessPendingKycVerification::class],
        TicketCreated::class => [ProcessTicketCreation::class],
        TicketReplyCreated::class => [ProcessTicketReplyCreation::class],
        WithdrawalSubmitted::class => [ProcessSubmittedWithdrawal::class],
        ItemSubmitted::class => [ProcessSubmittedItem::class],
        ItemResubmitted::class => [ProcessResubmittedItem::class],
        ItemUpdated::class => [ProcessUpdatedItem::class],
        ItemApproved::class => [ProcessApprovedItem::class],
        TransactionPending::class => [ProcessPendingTransaction::class],
        TransactionPaid::class => [ProcessPaidTransaction::class],
        RefundAccepted::class => [ProcessAcceptedRefund::class],
        SaleCreated::class => [ProcessNewSale::class],
        SaleCancelled::class => [ProcessCancelledSale::class],
        SaleRefunded::class => [ProcessRefundedSale::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }
}