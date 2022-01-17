<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div id="loginmodal-login">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logowanie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- LOGIN FORM-->
                    <form method="POST" id="loginform">
                        <div class="mb-3">
                            <input type="email" class="form-control" aria-describedby="emailHelp" autocomplete="email" placeholder="e-mail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="hasło" autocomplete="current-password" name=" password" required>
                            <small><a class="login-switch-passwordreset" href="#">Resetuj hasło</a></small>
                        </div>
                        <input type="hidden" id="redirect" name="redirect">
                        <button type="submit" class="btn btn-primary btn-facebook-login" style="margin: auto; display:block; padding-left: 20px; padding-right:20px; ">Zaloguj</button>
                    </form>

                    <hr />
                    <button type="button" class="btn btn-dark w-100 mb-2 btn_facebook-login"><i class="fab fa-facebook me-2"></i> Zaloguj korzystając z Facebook'a</button> <br />
                    <!-- <button type="button" class="btn btn-dark w-100 mb-2"><i class="fab fa-google me-2"></i> Zaloguj korzystając z Google'a</button> <br />
                    <button type="button" class="btn btn-dark w-100 mb-2"><i class="fab fa-twitter me-2"></i> Zaloguj korzystając z Twtitter'a</button> -->


                    <!-- END LOGIN FORM -->
                </div>

                <div class="modal-footer">
                    <small>
                        <p>Nie masz jeszcze konta? <a href="#" class="login-switch-register"><b><u>Zarejestruj się</u></b></a> lub skorzystaj z logowania za pomocą zewnętrznego serwisu.</p>
                    </small>
                </div>
            </div>

            <div id="loginmodal-register">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rejestracja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- LOGIN FORM-->
                    <form method="POST" id="registerform">
                        <div class="mb-3">
                            <label>Nazwa użytkownika/obiektu</label>
                            <input type="text" class="form-control" autocomplete="username" placeholder="Nazwa użytkownika" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label>Adres e-mail</label>
                            <input type="email" class="form-control" aria-describedby="emailHelp" autocomplete="email" placeholder="e-mail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label>Hasło</label>
                            <input type="password" class="form-control" placeholder="hasło" autocomplete="current-password" name=" password" required>
                        </div>
                        <input type="hidden" id="redirect" name="redirect">
                        <div style="text-align:center;">
                            <div class="g-recaptcha mb-3" style="display:inline-block" data-sitekey="6Ldl6d8dAAAAANuCA-InONqkE0EIWnuoMRDyIqGb"></div>
                            
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin: auto; display:block; padding-left: 20px; padding-right:20px; ">Zarejestruj</button>
                    </form>

                    <hr />
                    <button type="button" class="btn btn-dark w-100 mb-2 btn_facebook-login"><i class="fab fa-facebook me-2"></i> Zaloguj korzystając z Facebook'a</button> <br />
                </div>
                <div class="modal-footer">
                    <small>Masz już konto? <b><u><a href="#" class="login-switch-login">Zaloguj się</a></u></b></small>
                </div>
            </div>

            <div id="loginmodal-passwordreset">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Resetowanie hasła</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- LOGIN FORM-->
                    <form method="POST" id="passresetform">
                        <div class="mb-3">
                            <label>Adres e-mail</label>
                            <input type="email" class="form-control" aria-describedby="emailHelp" autocomplete="email" placeholder="e-mail" name="email" required>
                        </div>
                        <input type="hidden" id="redirect" name="redirect">
                        <div style="text-align:center;">
                            <div class="g-recaptcha mb-3" id="resetchapta" name="googlecaptcha" style="display:inline-block" data-sitekey="6Ldl6d8dAAAAANuCA-InONqkE0EIWnuoMRDyIqGb"></div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin: auto; display:block; padding-left: 20px; padding-right:20px; ">Resetuj hasło</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <small>
                        <small>Masz już konto? <b><u><a href="#" class="login-switch-login">Zaloguj się</a></u></b></small>
                    </small>
                </div>

            </div>


        </div>
    </div>