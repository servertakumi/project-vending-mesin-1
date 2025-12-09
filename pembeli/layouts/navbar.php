<div class="container position-sticky z-index-sticky top-0">
  <div class="row">
    <div class="col-12">
      <nav class="navbar navbar-expand-lg  blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
        <div class="container-fluid px-0">
          <a class="navbar-brand font-weight-bolder ms-sm-3" href="https://demos.creative-tim.com/material-kit/index" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom" target="_blank">
            <img src="assets/asset/images/logo1.png" style="width: 40px; height: 40px;" alt="">
            TAKUMI VENDING MESIN
          </a>
                <?php
                if (session_status() === PHP_SESSION_NONE) {
                  session_start();
                }
                ?>

                <!-- Cek apakah user sudah login -->
                <?php if (!isset($_SESSION['username'])): ?>
                  <!-- Belum login -->
                  <a href="login?page" class="btn btn-sm bg-gradient-info mb-0 me-1 mt-2 mt-md-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                      <path fill="#fff7f7" d="M12 14v2a6 6 0 0 0-6 6H4a8 8 0 0 1 8-8m0-1c-3.315 0-6-2.685-6-6s2.685-6 6-6s6 2.685 6 6s-2.685 6-6 6m0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4m9 6h1v5h-8v-5h1v-1a3 3 0 1 1 6 0zm-2 0v-1a1 1 0 1 0-2 0v1z" />
                    </svg>
                    <strong class="ms-2">Log in</strong>
                  </a>

                <?php else: ?>
                  <!-- Sudah login -->
                  <a href="logout?page" class="btn btn-sm bg-gradient-danger mb-0 me-1 mt-2 mt-md-0" title="Logout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                      <path fill="#fff" d="M16 13v-2H7V8l-5 4l5 4v-3zM20 3H10a2 2 0 0 0-2 2v4h2V5h10v14H10v-4H8v4a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z" />
                    </svg>
                  </a>
                <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
    </div>
  </div>
</div>