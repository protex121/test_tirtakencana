
@extends('layouts.app')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">MyArgonApp</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="{{ route('login') }}">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="py-7 bg-primary text-white text-center">
    <div class="container">
      <h1 class="display-3 fw-bold">Welcome to MyArgonApp</h1>
      <p class="lead my-4">Build beautiful landing pages fast with Argon Design System.</p>
      <a href="#features" class="btn btn-lg btn-white text-primary fw-bold">Explore Features</a>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-6">
    <div class="container">
      <div class="row text-center">
        <div class="col-lg-4 mb-4">
          <div class="card shadow-sm p-4">
            <div class="icon icon-shape bg-primary text-white rounded-circle mb-3">
              <i class="ni ni-settings-gear-65"></i>
            </div>
            <h5>Customizable</h5>
            <p>Easily customize components to fit your brand’s style and needs.</p>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card shadow-sm p-4">
            <div class="icon icon-shape bg-primary text-white rounded-circle mb-3">
              <i class="ni ni-html5"></i>
            </div>
            <h5>Bootstrap Based</h5>
            <p>Built on Bootstrap 5, responsive and modern by default.</p>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card shadow-sm p-4">
            <div class="icon icon-shape bg-primary text-white rounded-circle mb-3">
              <i class="ni ni-chart-bar-32"></i>
            </div>
            <h5>Analytics Ready</h5>
            <p>Includes charts and dashboard components to monitor your data.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="contact" class="py-4 bg-light text-center">
    <div class="container">
      <p class="mb-0">© 2025 MyArgonApp. All rights reserved.</p>
      <small>Contact: info@myargonapp.com</small>
    </div>
  </footer>
