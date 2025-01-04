<?php 
	$page_title = "My Admin Profile";

	session_start();
	require_once("config/function.php"); 

	if(isset($_SESSION['user'])  && isset($_SESSION['user_id']) && $_SESSION['role'] == "admin") {
		$user = $_SESSION['user'];
		$user_id = $_SESSION['user_id'];
		$logged_time = $_SESSION['last_login_timestamp'];
		$user_info = get_admin_user_info($user);
		
		if (empty($user_info) || ($user_info["id"]) != $user_id) {
			session_destroy();
			header("Location: login?logged_out=tru");

		} else if ((time() - $_SESSION['last_login_timestamp'] )> 10800) {
			header("Location: /logged_out");
		} 

	} else {
		session_destroy();
		header("Location: /logged_out");
	}

	require_once("layout/admin-header.php"); ?>


	<main id="main" class="main">
		
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
  
        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            
                            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                            <h2>Kevin Anderson</h2>
                            <h3>Web Designer</h3>
                            <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                </li>
                
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                </li>
                
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Subscriptions</button>
                                </li>
                
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                </li>
                            </ul>


                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">About</h5>
                                    <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>
                
                                    <h5 class="card-title">Profile Details</h5>
                
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                        <div class="col-lg-9 col-md-8">Kevin Anderson</div>
                                    </div>
                
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Company</div>
                                        <div class="col-lg-9 col-md-8">Lueilwitz, Wisoky and Leuschke</div>
                                    </div>
                
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Job</div>
                                        <div class="col-lg-9 col-md-8">Web Designer</div>
                                    </div>
                
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Country</div>
                                        <div class="col-lg-9 col-md-8">USA</div>
                                    </div>
                
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
                                    </div>
                
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
                                    </div>
                
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                                    </div>
                                </div>
            
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <!-- Profile Edit Form -->
                                    <form>
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="assets/img/profile-img.jpg" alt="Profile">
                                                <div class="pt-2">
                                                    <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fullName" type="text" class="form-control shadow-none" id="fullName" value="Kevin Anderson">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="about" class="form-control shadow-none" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="company" type="text" class="form-control shadow-none" id="company" value="Lueilwitz, Wisoky and Leuschke">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="job" type="text" class="form-control shadow-none" id="Job" value="Web Designer">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="country" type="text" class="form-control shadow-none" id="Country" value="USA">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="address" type="text" class="form-control shadow-none" id="Address" value="A108 Adam Street, New York, NY 535022">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="phone" type="text" class="form-control shadow-none" id="Phone" value="(436) 486-3538 x29071">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control shadow-none" id="Email" value="k.anderson@example.com">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="twitter" type="text" class="form-control shadow-none" id="Twitter" value="https://twitter.com/#">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="facebook" type="text" class="form-control shadow-none" id="Facebook" value="https://facebook.com/#">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="instagram" type="text" class="form-control shadow-none" id="Instagram" value="https://instagram.com/#">
                                            </div>
                                        </div>
                    
                                        <div class="row mb-3">
                                            <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="linkedin" type="text" class="form-control shadow-none" id="Linkedin" value="https://linkedin.com/#">
                                            </div>
                                        </div>
                    
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->
                                </div>

                                <div class="tab-pane fade pt-3" id="profile-settings">
                                    <!-- Settings Form -->
                                    <div class="p-2 mb-4">
                                        <div>
                                            <div class="flex-between ai-center applicants">
                                                <section>
                                                    <p class="xxsm b-5 mb-2 main">Monthly Subscribption - 36637FS</p>
                                                    <p class="b-5 ssm" style="margin-top: -10px;">Payment date: 2nd June, 2023 || Expiary date: 3rd July, 2023</p>
                                                </section>
                    
                                                <section class="flex ai-center no-break">
                                                    <button type="button" class="btn1 mr-2 flex ai-center">
                                                        <i class="fa-solid fa-download mr-1 fa-lg"></i> Receipt
                                                    </button>
                    
                                                    <button type="button" class="success-btn flex ai-center">
                                                        <i class="fa-solid fa-circle-check fa-lg mr-1"></i> <span class="b-2">Active</span>
                                                    </button>
                                                </section>
                                            </div>
                    
                                            <div class="flex-between ai-center applicants">
                                                <section>
                                                    <p class="xxsm b-5 mb-2 main">Monthly Subscribption - 24265DC</p>
                                                    <p class="b-5 ssm" style="margin-top: -10px;">Payment date: 5nd September, 2022 || Expiary date: 6rd Janury, 2023</p>
                                                </section>
                    
                                                <section class="flex ai-center no-break">
                                                    <button type="button" class="btn1 mr-2 flex ai-center">
                                                        <i class="fa-solid fa-download mr-1 fa-lg"></i> Receipt
                                                    </button>
                    
                                                    <button type="button" class="danger-btn flex ai-center">
                                                        <i class="fa-solid fa-circle-check fa-lg mr-1"></i> <span class="b-2">Expired</span>
                                                    </button>
                                                </section>
                                            </div>
                    
                                            <div class="flex-between ai-center applicants">
                                                <section>
                                                    <p class="xxsm b-5 mb-2 main">Monthly Subscribption - 23665DC</p>
                                                    <p class="b-5 ssm" style="margin-top: -10px;">Payment date: 2nd June, 2022 || Expiary date: 3rd July, 2023</p>
                                                </section>
                    
                                                <section class="flex ai-center no-break">
                                                    <button type="button" class="btn1 mr-2 flex ai-center">
                                                        <i class="fa-solid fa-download mr-1 fa-lg"></i> Receipt
                                                    </button>
                    
                                                    <button type="button" class="danger-btn flex ai-center">
                                                        <i class="fa-solid fa-circle-check fa-lg mr-1"></i> <span class="b-2">Expired</span>
                                                    </button>
                                                </section>
                                            </div>
                    
                                            <div class="flex-between ai-center applicants">
                                                <section>
                                                    <p class="xxsm b-5 mb-2 main">Monthly Subscribption - 24265DC</p>
                                                    <p class="b-5 ssm" style="margin-top: -10px;">Payment date: 2nd June, 2021 || Expiary date: 3rd July, 2022</p>
                                                </section>
                    
                                                <section class="flex ai-center no-break">
                                                    <button type="button" class="btn1 mr-2 flex ai-center">
                                                        <i class="fa-solid fa-download mr-1 fa-lg"></i> Receipt
                                                    </button>
                    
                                                    <button type="button" class="danger-btn flex ai-center">
                                                        <i class="fa-solid fa-circle-check fa-lg mr-1"></i> <span class="b-2">Expired</span>
                                                    </button>
                                                </section>
                                            </div>
                                        </div>
                                    </div><!-- End settings Form -->
                                </div>
                
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form>
                
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control shadow-none" id="currentPassword">
                                        </div>
                                    </div>
                
                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control shadow-none" id="newPassword">
                                        </div>
                                    </div>
                
                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                        <input name="renewpassword" type="password" class="form-control shadow-none" id="renewPassword">
                                        </div>
                                    </div>
                
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                    </form><!-- End Change Password Form -->
                                </div>
                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
	</main><!-- End #main -->


    <?php 
	require_once("layout/admin-footer.php");
?>