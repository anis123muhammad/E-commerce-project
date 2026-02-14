<footer class="bg-dark mt-5">
    <div class="container pb-5 pt-3">
        <div class="row">

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Get In Touch</h3>
                    <p>
                        No dolore ipsum accusam no lorem.<br>
                        123 Street, New York, USA<br>
                        exampl@example.com<br>
                        000 000 0000
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Important Links</h3>
                    <ul>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Refund Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>My Account</h3>
                    <ul>
                        {{-- <li><a href="{{ route('admin.login') }}">Login</a></li> --}}
                        <li><a href="#">Register</a></li>
                        <li><a href="#">My Orders</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="copy-right text-center">
                        <p>© {{ date('Y') }} Amazing Shop. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ asset('admin-assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/slick.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/custom.js') }}"></script>

<script>
    window.onscroll = function () {
        const navbar = document.getElementById("navbar");
        if (!navbar) return;

        const sticky = navbar.offsetTop;

        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky");
        } else {
            navbar.classList.remove("sticky");
        }
    };
</script>

</body>
</html>
