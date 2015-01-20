<div class="md-modal md-justMe" id="modal-1">
    <div class="md-content">
        <h4 class="modal-header">login</h4>
        <div>
            <form action="{{ URL::route('login') }}" method="post" id="login_form">
                <span style="color:red;">{{ Session::get('loginError') }}</span>
                <div class="form-group">
                    <input type="text" placeholder="Username" name="user" id="user">
                </div>

                <div class="form-group">
                    <input type="password" placeholder="Password" name="pass" id="pass">
                </div>

                <div id="signup" class="form-group">
                    <input type="email" placeholder="Email" name="email" id="email">
                </div>
                <div class="form-group">
                    <a id="signup_button">Sign Up</a>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="rememberme" id="rememberme" checked>
                    <label for="rememberme">
                        Remember me
                    </label>
                </div>

                <input type="submit" value="Login">
                <input type="button" value="Cancel" class="md-close">
            </form>

        </div>
    </div>
</div>