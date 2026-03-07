<div class="col-md-3">
  <ul id="account-panel" class="nav nav-pills flex-column" >
                        <li class="nav-item">
                            <a href="{{ route('front.account.profile') }}"  class="nav-link font-weight-bold @if (request()->routeIs('front.account.profile')) active @endif"><i class="fas fa-user-alt"></i> My Profile</a>
                        </li>
                        <li class="nav-item active">
                            <a href="{{  route('front.account.order') }}"  class="nav-link font-weight-bold @if (request()->routeIs('front.account.order')) active @endif "><i class="fas fa-shopping-bag"></i>My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('front.account.wishlist') }}"  class="nav-link font-weight-bold"><i class="fas fa-heart"></i> Wishlist</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#"  class="nav-link font-weight-bold"><i class="fas fa-lock"></i> Change Password</a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('user_auth.logout') }}"  class="nav-link font-weight-bold"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    </ul>
                </div>
