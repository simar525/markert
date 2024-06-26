@extends('themes.basic.workspace.layouts.app')
@section('title', translate('Withdrawals'))
@section('breadcrumbs', Breadcrumbs::render('workspace.withdrawals'))
@section('content')
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3 mb-4">
        <div class="col">
            <div class="dashboard-counter justify-content-start">
                <div class="dashboard-counter-icon">
                    <i class="fa fa-wallet"></i>
                </div>
                <div class="dashboard-counter-info">
                    <h6 class="dashboard-counter-title">{{ translate('Available Balance') }}</h6>
                    <p class="dashboard-counter-number">{{ getAmount(authUser()->balance) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-counter justify-content-start dashboard-counter-warning">
                <div class="dashboard-counter-icon">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <div class="dashboard-counter-info">
                    <h6 class="dashboard-counter-title">{{ translate('Pending Withdrawn') }}</h6>
                    <p class="dashboard-counter-number">
                        {{ getAmount($counters['pending_withdrawals']) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col col-md-12 col-xl">
            <div class="dashboard-counter justify-content-start dashboard-counter-info">
                <div class="dashboard-counter-icon">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                </div>
                <div class="dashboard-counter-info">
                    <h6 class="dashboard-counter-title">{{ translate('Total Withdraw') }}</h6>
                    <p class="dashboard-counter-number">
                        {{ getAmount($counters['total_withdrawals']) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-card card-v p-0">
        @if ($withdrawals->count() > 0 || request()->input('search') || request()->input('status'))
            <div class="table-search p-4">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row g-3 aligs-items-center">
                        <div class="col-12 col-lg-6 col-xxl-7">
                            <input type="text" name="search" placeholder="{{ translate('Search...') }}"
                                class="form-control form-control-md" value="{{ request('search') }}">
                        </div>
                        <div class="col-12 col-lg-3 col-xxl-3">
                            <select name="status" class="selectpicker selectpicker-md" title="{{ translate('Status') }}">
                                @foreach (\App\Models\Withdrawal::getStatusOptions() as $key => $value)
                                    <option value="{{ $key }}" @selected(request('status') == $key)>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary w-100 btn-md"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col">
                            <a href="{{ url()->current() }}" class="btn btn-outline-primary w-100 btn-md"><i
                                    class="fa-solid fa-rotate"></i></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="overflow-hidden">
                <div class="table-container">
                    <table class="dashboard-table table text-start table-borderless">
                        <thead>
                            <tr>
                                <th>{{ translate('ID') }}</th>
                                <th class="text-center">{{ translate('Amount') }}</th>
                                <th class="text-center">{{ translate('Method') }}</th>
                                <th class="text-center">{{ translate('Account') }}</th>
                                <th class="text-center">{{ translate('Status') }}</th>
                                <th class="text-center">{{ translate('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-muted">
                            @forelse ($withdrawals as $withdrawal)
                                <tr>
                                    <td><i class="fa-solid fa-hashtag me-1"></i>{{ $withdrawal->id }}</td>
                                    <td class="text-center">
                                        {{ getAmount($withdrawal->amount) }}
                                    </td>
                                    <td class="text-center">{{ $withdrawal->method }}</td>
                                    <td class="text-center">{{ demo(shortertext($withdrawal->account, 40)) }}</td>
                                    <td class="text-center">
                                        @if ($withdrawal->isPending())
                                            <div class="badge bg-orange rounded-2 fw-light px-3 py-2">
                                                {{ $withdrawal->getStatusName() }}
                                            </div>
                                        @elseif($withdrawal->isReturned())
                                            <div class="badge bg-purple rounded-2 fw-light px-3 py-2">
                                                {{ $withdrawal->getStatusName() }}
                                            </div>
                                        @elseif($withdrawal->isApproved())
                                            <div class="badge bg-blue rounded-2 fw-light px-3 py-2">
                                                {{ $withdrawal->getStatusName() }}
                                            </div>
                                        @elseif($withdrawal->isCompleted())
                                            <div class="badge bg-green rounded-2 fw-light px-3 py-2">
                                                {{ $withdrawal->getStatusName() }}
                                            </div>
                                        @elseif($withdrawal->isCancelled())
                                            <div class="badge bg-red rounded-2 fw-light px-3 py-2">
                                                {{ $withdrawal->getStatusName() }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ dateFormat($withdrawal->created_at) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="text-muted p-4">{{ translate('No data found') }}</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="dashboard-card-empty pd">
                <div class="py-4">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="200px" height="200px"
                            viewBox="0 0 727.89313 637.35997" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path id="a9fff5a8-4449-4722-8691-2681997674a8-117"
                                data-name="fc914514-1042-4f3e-9382-2a2bd3a05a2f"
                                d="M280.07945,131.32a2.73,2.73,0,0,0-2.727,2.727v93.012a2.73,2.73,0,0,0,2.727,2.727h317.156a2.73,2.73,0,0,0,2.727-2.727V134.047a2.73,2.73,0,0,0-2.727-2.727Z"
                                transform="translate(-236.05344 -131.32002)" fill="#e6e6e6" />
                            <path id="ef08fdaa-4829-440e-93ff-da8e736c3be7-118"
                                data-name="fc60a940-5b5f-47e1-886f-8b9349204f05"
                                d="M284.18544,222.953h308.942v-84.8h-308.942Z" transform="translate(-236.05344 -131.32002)"
                                fill="#fff" />
                            <path id="f7452840-914d-46a1-ae61-ea1c2fc2d2a5-119"
                                data-name="b37dca77-34e7-4938-924b-74ea49a8e34b"
                                d="M554.13149,205.36a4.5175,4.5175,0,1,0,0,9.035h18.069a4.5175,4.5175,0,1,0,0-9.035Z"
                                transform="translate(-236.05344 -131.32002)"
                                fill="{{ $themeSettings->colors->primary_color }}" />
                            <rect id="b2c9f911-15af-4e19-9f72-89a224d6cf2b" data-name="a114a1b8-363a-4115-bcea-0275bda15cb1"
                                x="132.07703" y="65.27802" width="208.58798" height="1.189" fill="#e6e6e6" />
                            <circle id="a570d7cb-c53f-47e1-9372-81d6b1f4b9cc"
                                data-name="fd059875-cd6f-429e-81eb-c199f1a3d666" cx="88.476" cy="49.23301" r="26.311"
                                fill="#e6e6e6" />
                            <path id="a3321d5c-167e-43b0-8c0e-18df1c8c5ae5-120"
                                data-name="ad693766-5e26-437f-8d3d-58ce33ee9e84"
                                d="M368.46245,189.961l-.659-.989,21.675-14.45,14.863,7.135,21.379-13.659.289.123,42.24,18.019,33.867-16.637,32.887,13.333,41.323,8.4.788.89-41.875-7.911-33.077-13.411-33.88,16.642-42.452-18.109-21.408,13.677-14.85-7.128Z"
                                transform="translate(-236.05344 -131.32002)" fill="#3f3d56" />
                            <path id="f7b9bcea-10c4-4c80-b4a6-3d8e323f573e-121"
                                data-name="ff424c2d-4733-4249-9b35-4eb43ebe2556"
                                d="M371.99342,205.983a3.863,3.863,0,0,0,0,7.725h40.41a3.863,3.863,0,0,0,.1239-7.725q-.06189-.001-.1239,0Z"
                                transform="translate(-236.05344 -131.32002)" fill="#e6e6e6" />
                            <path
                                d="M335.11281,180.22625a1.5779,1.5779,0,0,0-2.23148-.00009l-.00009.00009L326.10738,187V170.29649a1.578,1.578,0,0,0-3.15589,0V187l-6.77386-6.7738a1.57795,1.57795,0,0,0-2.23728,2.22581l.00571.00569,9.46759,9.46759a1.578,1.578,0,0,0,2.23157,0l9.46759-9.46759A1.5779,1.5779,0,0,0,335.11281,180.22625Z"
                                transform="translate(-236.05344 -131.32002)" fill="#fff" />
                            <path id="f7c5b60e-33a7-4042-9d2c-5c8c9116b84c-122"
                                data-name="ebf544e0-cedc-491d-9ace-ce79788cc3b4"
                                d="M404.85442,280.283a2.73,2.73,0,0,0-2.727,2.727v93.012a2.73,2.73,0,0,0,2.727,2.727h317.157a2.73,2.73,0,0,0,2.727-2.727V283.01a2.73,2.73,0,0,0-2.727-2.727Z"
                                transform="translate(-236.05344 -131.32002)" fill="#e6e6e6" />
                            <path id="a8273e4e-93d2-47bb-9b17-df51a96534af-123"
                                data-name="f05ecdaf-6a8f-49c4-b8a7-f7e5ce9efcf7"
                                d="M408.96144,371.916h308.943v-84.8h-308.943Z" transform="translate(-236.05344 -131.32002)"
                                fill="#fff" />
                            <path id="a87d1795-16f3-4774-9768-c375c1bdbb9e-124"
                                data-name="a9f7bc9d-00a6-4157-bba1-ffc7ec111a68"
                                d="M678.90743,354.325a4.5175,4.5175,0,1,0,0,9.035H696.9745a4.5175,4.5175,0,1,0,0-9.035H678.90743Z"
                                transform="translate(-236.05344 -131.32002)"
                                fill="{{ $themeSettings->colors->primary_color }}" />
                            <rect id="b60d1a48-178f-4eb5-a9a3-9e4316169c72"
                                data-name="a15d3d52-efbb-4636-8d15-228635c5d6e5" x="256.853" y="214.24202"
                                width="208.58801" height="1.189" fill="#e6e6e6" />
                            <circle id="f066d7d6-19fd-468d-830f-1318b53822b2"
                                data-name="e4ee77d8-efe6-4a2a-a3ed-71b8f3ee957e" cx="213.25099" cy="198.19701" r="26.311"
                                fill="{{ $themeSettings->colors->primary_color }}" />
                            <path id="fcead4ff-5625-4c61-90c0-6a9c2def1900-125"
                                data-name="fc1c89ac-2b6e-4831-b128-0ac2ab1fa850"
                                d="M493.23644,338.925l-.66-.989,21.675-14.45,14.864,7.135,21.379-13.659.289.123,42.239,18.019,33.868-16.637,32.887,13.332,41.323-36.6.788.89-41.87512,37.086-33.077-13.41-33.879,16.642-42.452-18.109-21.4079,13.677-14.846-7.125Z"
                                transform="translate(-236.05344 -131.32002)" fill="#3f3d56" />
                            <path id="b25442e4-8332-4a87-9c30-01930e0b437c-126"
                                data-name="bd690ac4-3df0-4871-95d5-adaa934b7c24"
                                d="M496.76943,354.946a3.863,3.863,0,1,0-.1258,7.725h0q.06294.001.1258,0h40.41a3.863,3.863,0,0,0,0-7.725Z"
                                transform="translate(-236.05344 -131.32002)" fill="#e6e6e6" />
                            <path
                                d="M438.72105,329.8438a1.57788,1.57788,0,0,0,2.23148.0001l.00009-.0001,6.77387-6.7738v16.70355a1.57794,1.57794,0,1,0,3.15588,0V323.07l6.77387,6.7738a1.57793,1.57793,0,1,0,2.23156-2.2315l-9.46759-9.46759a1.578,1.578,0,0,0-2.23156,0l-9.4676,9.46759a1.57791,1.57791,0,0,0,0,2.2315Z"
                                transform="translate(-236.05344 -131.32002)" fill="#fff" />
                            <path id="f3e6157c-e0fb-4525-9ebd-9efe95b1618f-127"
                                data-name="b1a491a7-739b-4f1f-bff8-dbf70f6892c8"
                                d="M238.78044,429.247a2.73,2.73,0,0,0-2.727,2.727v93.012a2.73,2.73,0,0,0,2.727,2.727h317.156a2.73,2.73,0,0,0,2.727-2.727V431.974a2.73,2.73,0,0,0-2.727-2.727Z"
                                transform="translate(-236.05344 -131.32002)" fill="#e6e6e6" />
                            <path id="b96defd0-9a2c-4c45-aa8c-b5fd1840c319-128"
                                data-name="acd48b1a-d10a-4276-b388-f016adebff0c"
                                d="M242.88744,520.88h308.943v-84.8h-308.943Z" transform="translate(-236.05344 -131.32002)"
                                fill="#fff" />
                            <path id="a2204f79-048d-45a5-9dbf-3ca685e385ac-129"
                                data-name="bed21912-b6c9-41df-a59b-963435bac71a"
                                d="M512.83244,503.288a4.5175,4.5175,0,0,0,0,9.035h18.069a4.5175,4.5175,0,1,0,0-9.035Z"
                                transform="translate(-236.05344 -131.32002)"
                                fill="{{ $themeSettings->colors->primary_color }}" />
                            <rect id="ece8f467-8c57-41a5-b787-946f11f73852"
                                data-name="a26455fb-834b-4368-afb2-80d86a75d46a" x="90.77801" y="363.20602"
                                width="208.58799" height="1.189" fill="#e6e6e6" />
                            <circle id="acd23665-8915-4d62-9edc-4433a6bf124b"
                                data-name="f17c58cd-37a1-42e1-9e5f-26c2ec8825b4" cx="47.17702" cy="347.16003" r="26.311"
                                fill="{{ $themeSettings->colors->primary_color }}" />
                            <path id="b2ebcab4-d8cf-428d-87b9-c73daac40ac9-130"
                                data-name="b803193f-4714-40c6-8606-08b9dea6d22d"
                                d="M327.16145,487.889l-.659-.989,21.675-14.451,14.863,7.135,21.38-13.663,42.528,18.141,33.867-16.637,32.883,13.337,41.323-16.6.788.89-41.87,17.08892-33.077-13.41-33.879,16.642-42.452-18.109-21.407,13.678-14.85-7.128Z"
                                transform="translate(-236.05344 -131.32002)" fill="#3f3d56" />
                            <path id="aca123b7-0fc2-4f3d-89c1-779a89955e8d-131"
                                data-name="b19b31b4-3a52-4fc9-8ed4-dc6729deb0ed"
                                d="M330.69444,503.909a3.863,3.863,0,0,0,0,7.725h40.41a3.863,3.863,0,1,0,.12579-7.725q-.06289-.001-.12579,0Z"
                                transform="translate(-236.05344 -131.32002)" fill="#e6e6e6" />
                            <path
                                d="M272.64708,478.80682a1.57789,1.57789,0,0,0,2.23148.00009l.00009-.00009,6.77386-6.77381v16.70356a1.578,1.578,0,0,0,3.15589.0101V472.033l6.77386,6.77381a1.57794,1.57794,0,0,0,2.23728-2.2258l-.00571-.00571-9.46759-9.46759a1.578,1.578,0,0,0-2.23157,0l-9.46759,9.46759A1.57792,1.57792,0,0,0,272.64708,478.80682Z"
                                transform="translate(-236.05344 -131.32002)" fill="#fff" />
                            <polygon
                                points="650.421 621.963 635.192 621.962 627.948 563.225 650.423 563.226 650.421 621.963"
                                fill="#ffb7b7" />
                            <path
                                d="M890.35773,768.04459l-49.10223-.00182v-.62107a19.113,19.113,0,0,1,19.112-19.11165h.00121l29.99.00121Z"
                                transform="translate(-236.05344 -131.32002)" fill="#2f2e41" />
                            <polygon
                                points="594.525 621.963 579.297 621.962 572.052 563.225 594.528 563.226 594.525 621.963"
                                fill="#ffb7b7" />
                            <path
                                d="M834.462,768.04459l-49.10223-.00182v-.62107a19.113,19.113,0,0,1,19.112-19.11165h.00121l29.99.00121Z"
                                transform="translate(-236.05344 -131.32002)" fill="#2f2e41" />
                            <path
                                d="M801.876,562.7659a11.64742,11.64742,0,0,0,.22044-17.85852l8.2771-25.29657-14.14586-8.77933L785.0405,546.71931A11.71051,11.71051,0,0,0,801.876,562.7659Z"
                                transform="translate(-236.05344 -131.32002)" fill="#ffb7b7" />
                            <path
                                d="M816.966,546.06636s-14.21389,76.9413-14.03663,91.87612c.2139,18.02258,8.23315,95.26319,8.23315,95.26319l20.41692-5.10422,3.85913-89.52616,16.14766-57.13785,6.21063,73.2855,6.23435,77.09012H887.7168L893.022,538.41,815.6899,535.8579Z"
                                transform="translate(-236.05344 -131.32002)" fill="#2f2e41" />
                            <path
                                d="M887.78713,391.02541l-40.83383,1.276-25.52114,158.2311s54.23243,24.88311,77.20146,7.01831S887.78713,391.02541,887.78713,391.02541Z"
                                transform="translate(-236.05344 -131.32002)" fill="#cbcbcb" />
                            <path
                                d="M852.69556,424.84092,818.242,622.62979l-21.693-6.38029,15.31269-71.4592,7.65634-71.4592L818.242,401.87189l26.7972-11.48451,7.65635-8.9324S868.00824,400.59584,852.69556,424.84092Z"
                                transform="translate(-236.05344 -131.32002)" fill="#2f2e41" />
                            <path
                                d="M870.56036,420.013l2.55211,207.721,52.31835-8.9324L921.60265,426.117l5.10423-26.7972-25.52115-11.48452L890.85168,381.455S868.00824,388.38789,870.56036,420.013Z"
                                transform="translate(-236.05344 -131.32002)" fill="#2f2e41" />
                            <polygon
                                points="593.673 274.38 582.189 270.552 565.6 344.563 551.563 403.262 571.98 407.09 591.121 343.287 593.673 274.38"
                                fill="#2f2e41" />
                            <path
                                d="M944.77087,575.18717a11.64742,11.64742,0,0,1-.22044-17.85852l-8.2771-25.29657,14.14586-8.77933,11.18713,35.88783a11.71051,11.71051,0,0,1-16.83545,16.04659Z"
                                transform="translate(-236.05344 -131.32002)" fill="#ffb7b7" />
                            <polygon
                                points="679.625 271.896 691.109 268.068 707.698 342.079 722.977 415.683 699.997 419.064 682.177 340.803 679.625 271.896"
                                fill="#2f2e41" />
                            <circle cx="870.17272" cy="346.13193" r="28.36217"
                                transform="translate(-295.44324 328.48424) rotate(-28.66322)" fill="#ffb7b7" />
                            <path d="M940.867,768.68h-230a1,1,0,0,1,0-2h230a1,1,0,0,1,0,2Z"
                                transform="translate(-236.05344 -131.32002)" fill="#cbcbcb" />
                            <path
                                d="M860.28291,309.0187c27.11346-7.81878,34.80965,14.6536,34.80965,14.6536,13.06919,8.6706,4.8868,19.54136,4.8868,19.54136,3.29768.73251-3.29589,20.03047-5.49455,19.54211-1.17309-.26065-4.18975,3.34024-6.74828,6.75522a13.54093,13.54093,0,0,0-2.61377.25124l4.96414-18.36476s-16.73271-2.56353-21.86291-10.62415c-4.9083-7.71172-21.06612-10.14646-25.66442-4.99535a11.6268,11.6268,0,0,0-1.63988-4.16385,8.31927,8.31927,0,0,0-2.411-2.41726C842.57421,311.91948,860.28291,309.0187,860.28291,309.0187Z"
                                transform="translate(-236.05344 -131.32002)" fill="#2f2e41" />
                        </svg>
                    </div>
                    <h4>{{ translate('You do not have any withdrawals') }}</h4>
                    <p class="mb-0">
                        {{ translate('When you have withdrawal requests, you will be able to see them here.') }}
                    </p>
                </div>
            </div>
        @endif
    </div>
    {{ $withdrawals->links() }}
    <div class="modal fade" id="withdrawModel" tabindex="-1" aria-labelledby="withdrawModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0 p-0 mb-3">
                    <h1 class="modal-title fs-5" id="withdrawModelLabel">{{ translate('Withdraw') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    @if (authUser()->hasWithdrawalAccount())
                        @if (authUser()->balance > authUser()->withdrawalMethod->minimum)
                            <form action="{{ route('workspace.withdrawals.withdraw') }}" method="POST">
                                @csrf
                                <p class="mb-4">
                                    {{ translate('Are you sure you want to withdraw :amount to :account via :method?', [
                                        'amount' => getAmount(authUser()->balance),
                                        'account' => authUser()->withdrawal_account,
                                        'method' => authUser()->withdrawalMethod->name,
                                    ]) }}
                                </p>
                                <div class="row justify-content-center g-3">
                                    <div class="col-12 col-lg">
                                        <button type="button" class="btn btn-outline-primary btn-md w-100"
                                            data-bs-dismiss="modal">{{ translate('Cancel') }}</button>
                                    </div>
                                    <div class="col-12 col-lg">
                                        <button class="btn btn-primary btn-md w-100">{{ translate('Confirm') }}</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-danger mb-0">
                                <i class="fa-regular fa-circle-question me-2"></i>
                                {{ translate('Your balance is less than the minimum withdrawal limit') }}
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fa-regular fa-circle-question me-2"></i>
                            {{ translate('Missing withdrawal details alert') }}
                        </div>
                        <a href="{{ route('workspace.settings.withdrawal') }}" class="btn btn-outline-primary btn-md">
                            {{ translate('Setup Now') }} <i class="fa-solid fa-arrow-right fa-rtl ms-1"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
