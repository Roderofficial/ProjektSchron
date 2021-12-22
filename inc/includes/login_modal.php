<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Logowanie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- LOGIN FORM-->
                <form method="POST" id="loginform">
                    <div class="mb-3">
                        <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="e-mail" name="email">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="hasło" name="password">
                    </div>
                        <input type="hidden" id="redirect" name="redirect">
                    <button type="submit" class="btn btn-primary" style="margin: auto; display:block; padding-left: 20px; padding-right:20px; ">Zaloguj</button>
                </form>

                <hr />
                <button type="button" class="btn btn-dark w-100 mb-2"><i class="fab fa-facebook me-2"></i> Zaloguj korzystając z Facebook'a</button> <br />
                <button type="button" class="btn btn-dark w-100 mb-2"><i class="fab fa-google me-2"></i> Zaloguj korzystając z Google'a</button> <br />
                <button type="button" class="btn btn-dark w-100 mb-2"><i class="fab fa-twitter me-2"></i> Zaloguj korzystając z Twtitter'a</button>


                <!-- END LOGIN FORM -->
            </div>

            <div class="modal-footer">
                <p>Nie masz jeszcze konta? <b><u>Zarejestruj się</u></b> lub skorzystaj z logowania za pomocą zewnętrznego serwisu.</p>
            </div>

        </div>
    </div>
</div>