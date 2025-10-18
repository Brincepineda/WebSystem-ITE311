<div class="hero-section">
    <div class="container">
        <h1><i class="bi bi-envelope-heart"></i> Contact Us</h1>
        <p class="lead">Get in touch with us for any questions or collaboration opportunities</p>
    </div>
</div>

<div class="content-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="feature-card">
                    <h3 class="text-center mb-4"><i class="bi bi-chat-dots text-primary"></i> Send us a Message</h3>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">
                                    <i class="bi bi-person"></i> First Name
                                </label>
                                <input type="text" class="form-control" id="firstName" placeholder="Enter your first name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">
                                    <i class="bi bi-person"></i> Last Name
                                </label>
                                <input type="text" class="form-control" id="lastName" placeholder="Enter your last name" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email address" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">
                                <i class="bi bi-tag"></i> Subject
                            </label>
                            <select class="form-select" id="subject" required>
                                <option value="">Choose a subject...</option>
                                <option value="general">General Inquiry</option>
                                <option value="technical">Technical Support</option>
                                <option value="collaboration">Collaboration</option>
                                <option value="feedback">Feedback</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label">
                                <i class="bi bi-chat-text"></i> Message
                            </label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Write your message here..." required></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-custom btn-lg">
                                <i class="bi bi-send"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="row mt-5">
                    <div class="col-md-4 text-center mb-4">
                        <div class="feature-card h-100">
                            <i class="bi bi-geo-alt display-4 text-primary mb-3"></i>
                            <h5>Location</h5>
                            <p class="text-muted">Philippines<br>Available Online</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-center mb-4">
                        <div class="feature-card h-100">
                            <i class="bi bi-envelope display-4 text-success mb-3"></i>
                            <h5>Email</h5>
                            <p class="text-muted">pineda@ite311.com<br>Available 24/7</p>
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-center mb-4">
                        <div class="feature-card h-100">
                            <i class="bi bi-clock display-4 text-warning mb-3"></i>
                            <h5>Response Time</h5>
                            <p class="text-muted">Within 24 hours<br>Monday - Friday</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="lead">
                        <i class="bi bi-heart text-danger"></i> 
                        Thank you for your interest in our CodeIgniter project!
                    </p>
                    <a href="<?= site_url('/') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-house"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
