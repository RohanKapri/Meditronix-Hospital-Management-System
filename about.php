<?php
include('header.php');
?>
<div class="container-fluid bg-light p-0 m-0">

        <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <div class="container-fluid bg-white py-5 px-4 px-lg-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 position-relative wow fadeInLeft" data-wow-delay="0.2s">
                <div class="about-img pb-5 ps-5 position-relative">
                    <img src="img/about-1.jpg" class="img-fluid rounded shadow-lg w-100" style="object-fit: cover;" alt="Professional Physiotherapist">
                    <div class="about-img-inner position-absolute top-50 start-50 translate-middle border border-5 border-white shadow-lg">
                        <img src="img/about-2.jpg" class="img-fluid rounded-circle w-100 h-100" alt="Therapist Massage Session">
                    </div>
                    <div class="about-experience position-absolute bg-primary text-white px-4 py-2 rounded-pill shadow">15+ Years Trusted Excellence</div>
                </div>
            </div>

            <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                <div class="section-title text-start mb-4">
                    <h4 class="sub-title text-uppercase text-primary fw-bold mb-3">About Meditronix</h4>
                    <h1 class="display-5 fw-bold text-dark">Empowering Recovery, Elevating Healthcare Standards</h1>
                </div>

                <p class="mb-4 text-secondary fs-5">
                    <strong>Meditronix</strong> has been a pioneer in delivering modern physiotherapy and healthcare management solutions, combining advanced technology with empathetic, hands-on patient care. We are not merely a clinic — we are the foundation for thousands of successful recovery stories and enhanced healthcare processes. Trusted by individuals, hospitals, and healthcare institutions for over <strong>15 years</strong>, we lead with a commitment to excellence and measurable outcomes.
                </p>

                <p class="mb-4 text-secondary fs-5">
                    Our integrated approach leverages AI-powered diagnostics, evidence-based physiotherapy protocols, and cutting-edge rehabilitation technology to transform how recovery is achieved. Every patient’s journey is unique, and at Meditronix, we craft tailored programs that focus not only on immediate relief but also on long-term physical wellness and improved life quality.
                </p>

                <p class="mb-4 text-secondary fs-5">
                    Through our hospital management systems, we ensure seamless integration between medical records, therapy progress, and patient communication, creating a unified ecosystem where healthcare professionals and patients thrive together in clarity and efficiency.
                </p>

                <div class="mb-4">
                    <p class="text-secondary fs-6"><i class="fa fa-check-circle text-primary me-2"></i> AI-Powered Recovery Monitoring & Analytics</p>
                    <p class="text-secondary fs-6"><i class="fa fa-check-circle text-primary me-2"></i> Digital Health Dashboards for Transparent Progress</p>
                    <p class="text-secondary fs-6"><i class="fa fa-check-circle text-primary me-2"></i> 24/7 Virtual Assistance & Online Consultations</p>
                    <p class="text-secondary fs-6"><i class="fa fa-check-circle text-primary me-2"></i> Meditronix HMS Integration for Unified Records</p>
                    <p class="text-secondary fs-6"><i class="fa fa-check-circle text-primary me-2"></i> Trusted by 10,000+ Patients & Healthcare Institutions</p>
                </div>

                <div class="d-flex flex-wrap gap-4 align-items-center mt-4">
                    <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5 shadow-lg">Explore Our Services</a>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-phone-alt text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-secondary">For Consultation or Queries</small>
                            <h6 class="fw-bold m-0">+91 99999-99999</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .carousel-image {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
    }
    .about-img-inner {
        width: 160px;
        height: 160px;
        overflow: hidden;
        transition: 0.5s;
    }
    .about-img-inner img {
        transition: 0.5s;
        object-fit: cover;
    }
    .about-img-inner img:hover {
        transform: scale(1.1);
    }
    .about-experience {
        bottom: 20px;
        right: 20px;
        font-size: 14px;
    }
    .btn-primary {
        background: linear-gradient(45deg, #1e88e5, #42a5f5);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(45deg, #1565c0, #1e88e5);
    }
    .about-img {
        position: relative;
    }
    .about-experience {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #0d6efd;
        padding: 5px 15px;
        font-weight: 600;
        font-size: 14px;
        border-radius: 50px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>


<div class="container-fluid bg-light py-5">
    <div class="container" style="max-width: 90%;">
        <div class="text-center mb-5">
            <h6 class="text-uppercase fw-bold text-primary mb-2" style="letter-spacing: 2px; font-size: 18px;">
                Meditronix Healthcare Professionals
            </h6>
            <h1 class="display-4 fw-bold mb-3">Expert Doctors, Trusted Healing</h1>
            <p class="fs-5 text-muted">
                Over <b>15+ Years</b> delivering exceptional care through innovation, expertise, and dedication in medical rehabilitation and physiotherapy excellence.
            </p>
        </div>

        <div class="doctor-grid">
            <?php
                $db = mysqli_connect("localhost", "root", "", "meditronix_new");
                $query = "SELECT * FROM `doctors`";
                $result = mysqli_query($db, $query);
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="doctor-card">
                <div class="doctor-icon">
                    <i class="fas fa-user-md fa-3x text-primary"></i>
                </div>
                <h4 class="doctor-id"><?php echo $row['user_id']; ?></h4>
                <p><b>Specialization:</b> <?php echo ucfirst($row['specialization']); ?></p>
                <p><b>Experience:</b> <?php echo $row['experience']; ?> Years</p>
                <p><b>Availability:</b> <?php echo $row['availability']; ?></p>
                <p><b>Status:</b> <?php echo strtolower($row['status']); ?></p>
                <p class="text-muted" style="font-size: 13px;">
                    <small>Created on: <?php echo $row['created_at']; ?></small>
                </p>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<style>
    .doctor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .doctor-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        padding: 25px 20px;
        text-align: center;
        transition: 0.3s ease;
    }

    .doctor-card:hover {
        box-shadow: 0 4px 30px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }

    .doctor-icon {
        margin-bottom: 15px;
        color: #0d6efd;
    }

    .doctor-id {
        font-size: 1.2rem;
        color: #0d6efd;
        margin-bottom: 12px;
        font-weight: 600;
    }

    .doctor-card p {
        margin-bottom: 7px;
        font-size: 15px;
        color: #333;
    }
</style>

<!-- Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Service Section Start -->
<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Meditronix Medical Services</h4>
            <h1 class="display-4 mb-4 fw-bold">Professional, Affordable & Trusted Healthcare Services</h1>
            <p class="lead text-secondary">Empowering lives through excellence in medical innovation, rehabilitation, and advanced physiotherapy solutions.</p>
        </div>
        <div id="serviceCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $result = mysqli_query($db, "SELECT * FROM `services`");
                $isFirst = true;
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                    <div class="carousel-item <?php if ($isFirst) { echo 'active'; $isFirst = false; } ?>">
                        <div class="d-flex justify-content-evenly">
                            <div class="card shadow-lg border-0 m-3" style="width: 22rem;">
                                <div class="card-body text-center p-4">
                                    <div class="mb-4">
                                        <i class="fas fa-stethoscope fa-4x text-primary"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark">Service ID: <?php echo $row['id']; ?></h5>
                                    <h4 class="text-primary mb-3"> <?php echo $row['name']; ?> </h4>
                                    <p class="card-text text-secondary"> <?php echo $row['description']; ?> </p>
                                    <h5 class="text-success fw-bold">Fee: ₹<?php echo $row['fee']; ?></h5>
                                    <p class="text-muted small">Status: <?php echo $row['status']; ?></p>
                                    <p class="text-muted small">Created At: <?php echo $row['created_at']; ?></p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit_service.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary rounded-pill px-4">Edit</a>
                                        <a href="delete_service.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger rounded-pill px-4">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-lg border-0 m-3" style="width: 22rem;">
                                <div class="card-body text-center p-4">
                                    <div class="mb-4">
                                        <i class="fas fa-user-md fa-4x text-primary"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark">Service ID: <?php echo $row['id']; ?></h5>
                                    <h4 class="text-primary mb-3"> <?php echo $row['name']; ?> </h4>
                                    <p class="card-text text-secondary"> <?php echo $row['description']; ?> </p>
                                    <h5 class="text-success fw-bold">Fee: ₹<?php echo $row['fee']; ?></h5>
                                    <p class="text-muted small">Status: <?php echo $row['status']; ?></p>
                                    <p class="text-muted small">Created At: <?php echo $row['created_at']; ?></p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit_service.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary rounded-pill px-4">Edit</a>
                                        <a href="delete_service.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger rounded-pill px-4">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-lg border-0 m-3" style="width: 22rem;">
                                <div class="card-body text-center p-4">
                                    <div class="mb-4">
                                        <i class="fas fa-heartbeat fa-4x text-primary"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark">Service ID: <?php echo $row['id']; ?></h5>
                                    <h4 class="text-primary mb-3"> <?php echo $row['name']; ?> </h4>
                                    <p class="card-text text-secondary"> <?php echo $row['description']; ?> </p>
                                    <h5 class="text-success fw-bold">Fee: ₹<?php echo $row['fee']; ?></h5>
                                    <p class="text-muted small">Status: <?php echo $row['status']; ?></p>
                                    <p class="text-muted small">Created At: <?php echo $row['created_at']; ?></p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit_service.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary rounded-pill px-4">Edit</a>
                                        <a href="delete_service.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger rounded-pill px-4">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-lg border-0 m-3" style="width: 22rem;">
                                <div class="card-body text-center p-4">
                                    <div class="mb-4">
                                        <i class="fas fa-ambulance fa-4x text-primary"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark">Service ID: <?php echo $row['id']; ?></h5>
                                    <h4 class="text-primary mb-3"> <?php echo $row['name']; ?> </h4>
                                    <p class="card-text text-secondary"> <?php echo $row['description']; ?> </p>
                                    <h5 class="text-success fw-bold">Fee: ₹<?php echo $row['fee']; ?></h5>
                                    <p class="text-muted small">Status: <?php echo $row['status']; ?></p>
                                    <p class="text-muted small">Created At: <?php echo $row['created_at']; ?></p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit_service.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary rounded-pill px-4">Edit</a>
                                        <a href="delete_service.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger rounded-pill px-4">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#serviceCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-primary rounded-circle"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#serviceCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-primary rounded-circle"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="text-center mt-5">
            <a href="#" class="btn btn-primary rounded-pill px-5 py-3">Explore More</a>
        </div>
    </div>
</div>
<!-- Service Section End -->

<!-- Social Media Links -->
<div class="container-fluid bg-dark py-4">
    <div class="container text-center">
        <a href="#" class="text-white px-3"><i class="fab fa-facebook-f fa-lg"></i></a>
        <a href="#" class="text-white px-3"><i class="fab fa-twitter fa-lg"></i></a>
        <a href="#" class="text-white px-3"><i class="fab fa-instagram fa-lg"></i></a>
        <a href="#" class="text-white px-3"><i class="fab fa-linkedin-in fa-lg"></i></a>
        <a href="#" class="text-white px-3"><i class="fab fa-youtube fa-lg"></i></a>
    </div>
</div>

<style>
    .carousel-item {
        transition: transform 0.6s ease, opacity 0.6s ease;
    }

    .card {
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: 0.5s;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        padding: 2rem;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 3rem;
        height: 3rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004a9c;
    }
</style>

        <?php
include('footer.php');
?>