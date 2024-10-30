@extends('layouts/layoutMaster')

@section('title', 'Account settings - Pages')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="nav-align-top">
      <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-account')}}"><i class="ri-group-line me-2"></i> Account</a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-security')}}"><i class="ri-lock-line me-2"></i> Security</a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-billing')}}"><i class="ri-bookmark-line me-2"></i> Billing & Plans</a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-notifications')}}"><i class="ri-notification-4-line me-2"></i> Notifications</a></li>
        <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="ri-link-m me-2"></i> Connections</a></li>
      </ul>
    </div>
    <div class="card">
      <div class="row">
        <div class="col-md-6 col-12">
          <div class="card-header mb-1">
            <h5 class="mb-1">Connected Accounts</h5>
            <p class="mb-0 card-subtitle mt-0">Display content from your connected accounts on your site</p>
          </div>
          <!-- Connections -->
          <div class="card-body">
            <div class="d-flex mb-4 align-items-center">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/google.png')}}" alt="google" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                <div class="mb-sm-0 mb-2">
                  <h6 class="mb-0">Google</h6>
                  <small>Calendar and contacts</small>
                </div>
                <div class="text-end">
                  <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" checked />
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mb-4 align-items-center">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/slack.png')}}" alt="slack" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                <div class="mb-sm-0 mb-2">
                  <h6 class="mb-0">Slack</h6>
                  <small>Communication</small>
                </div>
                <div class="text-end">
                  <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" />
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mb-4 align-items-center">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/github.png')}}" alt="github" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                <div class="mb-sm-0 mb-2">
                  <h6 class="mb-0">Github</h6>
                  <small>Manage your Git repositories</small>
                </div>
                <div class="text-end">
                  <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" checked />
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex mb-4 align-items-center">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/mailchimp.png')}}" alt="mailchimp" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                <div class="mb-sm-0 mb-2">
                  <h6 class="mb-0">Mailchimp</h6>
                  <small>Email marketing service</small>
                </div>
                <div class="text-end">
                  <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" checked />
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/asana.png')}}" alt="asana" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                <div class="mb-sm-0 mb-2">
                  <h6 class="mb-0">Asana</h6>
                  <small>Communication</small>
                </div>
                <div class="text-end">
                  <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" />
                  </div>
                </div>
              </div>
            </div>
            <!-- /Connections -->
          </div>
        </div>
        <div class="col-md-6 col-12">
          <div class="card-header mb-1">
            <h5 class="mb-1">Social Accounts</h5>
            <p class="mb-0 card-subtitle mt-0">Display content from social accounts on your site</p>
          </div>
          <div class="card-body">
            <!-- Social Accounts -->
            <div class="d-flex mb-4 align-items-center me-2">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/facebook.png')}}" alt="facebook" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 row  align-items-center">
                <div class="col-7">
                  <h6 class="mb-0">Facebook</h6>
                  <small>Not Connected</small>
                </div>
                <div class="col-5 text-end">
                  <button class="btn btn-outline-secondary btn-icon"><i class="ri-link ri-22px"></i></button>
                </div>
              </div>
            </div>
            <div class="d-flex mb-4 align-items-center me-2">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/twitter.png')}}" alt="twitter" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 row  align-items-center">
                <div class="col-7">
                  <h6 class="mb-0">Twitter</h6>
                  <a href="{{config('variables.twitterUrl')}}" target="_blank" class="small">{{'@'.config('variables.creatorName')}}</a>
                </div>
                <div class="col-5 text-end">
                  <button class="btn btn-outline-danger btn-icon"><i class="ri-delete-bin-line ri-22px"></i></button>
                </div>
              </div>
            </div>
            <div class="d-flex mb-4 align-items-center me-2">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/instagram.png')}}" alt="instagram" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 row  align-items-center">
                <div class="col-7">
                  <h6 class="mb-0">instagram</h6>
                  <a href="{{config('variables.instagramUrl')}}" target="_blank" class="small">{{'@'.config('variables.creatorName')}}</a>
                </div>
                <div class="col-5 text-end">
                  <button class="btn btn-outline-danger btn-icon"><i class="ri-delete-bin-line ri-22px"></i></button>
                </div>
              </div>
            </div>
            <div class="d-flex mb-4 align-items-center me-2">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/dribbble.png')}}" alt="dribbble" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 row  align-items-center">
                <div class="col-7">
                  <h6 class="mb-0">Dribbble</h6>
                  <small>Not Connected</small>
                </div>
                <div class="col-5 text-end">
                  <button class="btn btn-outline-secondary btn-icon"><i class="ri-link ri-22px"></i></button>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-center me-2">
              <div class="flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/behance.png')}}" alt="behance" class="me-4" height="32">
              </div>
              <div class="flex-grow-1 row  align-items-center">
                <div class="col-7">
                  <h6 class="mb-0">Behance</h6>
                  <small>Not Connected</small>
                </div>
                <div class="col-5 text-end">
                  <button class="btn btn-outline-secondary btn-icon"><i class="ri-link ri-22px"></i></button>
                </div>
              </div>
            </div>
            <!-- /Social Accounts -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection