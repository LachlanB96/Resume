<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Lachlan, Brown, LachlanB, LachlanB.com, Lachlanb.net. LachlanB.org, LachlanB.com.au, Software Developer, Software, Engineer, Architect, Resume, CV, Ethereum, Blockchain, Ether, Bitcoin, Website, Solidity, Smart Contracts, Smart, Contract">
    <title>About LachlanB</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.png">
    <script defer src="js/fontawesome-all.js"></script>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>

    <?php

    $homeIcons = array(
        "fab fa-twitter",
        "fab fa-telegram",
        "fa fa-envelope",
        "fab fa-github-square",
        "fa fa-graduation-cap",
        "fa fa-cogs",
        "fab fa-ethereum");

    $skills = array(
        "Heading!"=>array("Style"=>20, "Conceptual"=>30, "Experience"=>10, "Design"=>5),
        "Solidity"=>array("Conceptual"=>40, "Syntax"=>10, "Style"=>20),
        "JS"=>array("Conceptual"=>40, "Syntax"=>10, "Style"=>20),
        "PHP"=>array("Conceptual"=>40, "Syntax"=>10, "Style"=>20),
        ".NET"=>array("Conceptual"=>40, "Syntax"=>10, "Style"=>20),
        "Python2/3"=>array("Conceptual"=>40, "Syntax"=>10, "Style"=>20));

    $sections = array("home", "about", "skills", "resume", "stats", "blog", "hobbies", "achievements", "other", "contact");

    $x = 0;

    ?>

    <div class="section">
        <div class="home">
            <div class="title">
                LachlanB
            </div>
            <div class="content">
                <div class="text">
                    I am a fully professional freelance creative User Interface Designer Developer. Involving with latest web designing and technologies is a great feel free to contact creative. I am a fully professional freelance creative User Interface Designer Developer. Involving with latest web designing and technologies is a great feel free to contact creative. I am a fully professional freelance creative User Interface Designer Developer. Involving with latest web designing and technologies is a great feel free to contact creative. I am a fully professional freelance creative User Interface Designer Developer. Involving with latest web designing and technologies is a great feel free to contact creative. I am a fully professional freelance creative User Interface Designer Developer. Involving with latest web designing and technologies is a great feel free to contact creative.
                </div>
                <div class="box-list">
                    <?php foreach ($homeIcons as $icon) { ?>
                    <a href="#"><div class="item <?=$icon?>"></div></a>
                    <?php } ?>   
                </div>
                <i class="fas fa-angle-double-down fa-2x"></i>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-static-top navbar-default navbar-inverse">
        <div class="container">
            <div class="nav navbar-nav">
                <?php foreach ($sections as $section) { ?>
                <li>
                    <a href="#<?=$section?>">
                        <div class="item">
                            <?=$section?>
                        </div>
                    </a>
                </li>
                <?php } ?>   
            </div>
        </div>
    </nav>


    <div class="section">
        <div class="about">
            <div class="title">
                About Me
            </div>
            <div class="content row">
                <div class="col-md-8">
                    <div class="heading">
                        Objective
                    </div>
                    <div class="text">
                        <p>An opportunity to work and upgrade oneself, as well as being involved in an organization that believes in gaining a competitive edge and giving back to the community. I'm presently expanding my solid experience in UI / UX design. I focus on using my interpersonal skills to build good user experience and create a strong interest in my employers. I hope to develop skills in motion design and my knowledge of the Web, and become an honest asset to the business. As an individual, I'm self-confident you’ll find me creative, funny and naturally passionate. I’m a forward thinker, which others may find inspiring when working as a team.</p>
                    </div>

                    <div class="heading">
                        What I Do?
                    </div>
                    <div class="text">
                        I have been working as a web interface designer since. I have a love of clean, elegant styling, and I have lots of experience in the production of CSS3 and HTML5 for modern websites. I loving creating awesome as per my clients’ need. I think user experience when I try to craft something for my clients. Making a design awesome.
                    </div>
                    <div class="list">
                        <li>User Experience Design</li>
                        <li>Interface Design</li>
                        <li>Product Design</li>
                        <li>Branding Design</li>
                        <li>Digital Painting</li>
                        <li>Video Editing</li>
                    </div>
                    <div class="input">
                        <div class="btn btn-info btn-lg" href="#contact"><i class="fa fa-paper-plane"></i>Send me message</div>
                        <div class="btn btn-primary btn-lg" href="#"><i class="fa fa-download"></i>download my cv</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="biography">
                        <div class="myphoto">
                        </div>
                        <ul>
                            <li><strong>Name: </strong>Lachlan Brown</li>
                            <li><strong>Date of birth: </strong>6th August 1996</li>
                            <li><strong>Nationality: </strong>Australian</li>
                            <li><strong>Phone: </strong> Hidden</li>
                            <li><strong>Email: </strong> enquiry@lachlanb.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-dark">
        <div class="container">
            <h2 class="section-title">Skills</h2>
            <div class="row">
                <div class="col-md-6">
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                    <p>====================</p>
                </div>
                <div class="col-md-6">
                    <?php
                    foreach($skills as $heading => $attributes) {
                        echo '<h3>'.$heading.'</h3>';
                        echo '<div class="progress">';
                        foreach($attributes as $attr => $value) {
                            echo '<div class="progress-bar" style="width:'.$value.'%">';
                            echo '<p>'.$attr.'</p>';
                            echo '</div>';
                        }
                        echo '</div>';
                    } ?>
                </div>
            </div>
            <div class="row">
                <div class="test">
                    <div class="test2">
                        <p>Test</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <h3>More skills</h3>
                <ul>
                    <li>
                        Smart
                    </li>
                    <li>
                        Smart
                    </li>
                    <li>
                        Smart
                    </li>
                    <li>
                        Smart
                    </li>
                    <li>
                        Smart
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <h2>Resume</h2>
            <div class="row">
                <div class="col-md-12">
                    <h3>Education</h3>
                    <li>
                        <div class="posted-date">
                            <span class="month">2007-2011</span>
                        </div>

                        <div class="timeline-panel">

                            <div class="timeline-heading">
                                <h3>Bachelor degree certificate</h3>
                                <span>BA(Hons) in UI Engineering, Arts University, Pabna, USA</span>
                            </div>

                            <div class="timeline-body">
                                <p>I have completed UI Engineering degree from ABC University, Boston, USA at feel the charm of existence in this spot, which was creat.</p>
                            </div>
                        </li>

                        <li class="timeline-inverted">
                            <div class="posted-date">
                                <span class="month">2004-2006</span>
                            </div>

                            <div class="timeline-panel">
                                <div class="timeline-content">
                                    <div class="timeline-heading">
                                        <h3>Higher Secondary certificate</h3>
                                        <span>Typography Arts, FA College, New York, USA</span>
                                    </div>

                                    <div class="timeline-body">
                                        <p>From this college of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend.</p>
                                    </div>
                                </div> 
                            </div> 
                        </li>

                        <li>
                            <div class="posted-date">
                                <span class="month">2000-2003</span>
                            </div>

                            <div class="timeline-panel">
                                <div class="timeline-content">
                                    <div class="timeline-heading">
                                        <h3>Secondary school certificate</h3>
                                        <span>Creative Arts, Julius Jr. school, USA</span>
                                    </div>

                                    <div class="timeline-body">
                                        <p>I was awesome at arts, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy.</p>
                                    </div>
                                </div> 
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="resume-title">
                    <h3>Experience</h3>
                </div>
                <div class="resume">
                    <ul class="timeline">
                        <li class="timeline-inverted">
                            <div class="posted-date">
                                <span class="month">2011-2013</span>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-content">
                                    <div class="timeline-heading">
                                        <h3>Junior ui designer</h3>
                                        <span>XYZ Design Home, One Street, Boston</span>
                                    </div>
                                    <div class="timeline-body">
                                        <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend.</p>
                                    </div>
                                </div> 
                            </div> 
                        </li>
                        <li>
                            <div class="posted-date">
                                <span class="month">2013-2015</span>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-content">
                                    <div class="timeline-heading">
                                        <h3>Lead UX Consultant</h3>
                                        <span>Lucky8 Designing Firm, California</span>
                                    </div>
                                    <div class="timeline-body">
                                        <p>Completely provide access to seamless manufactured products before functionalized synergy. Progressively redefine competitive.</p>
                                    </div>
                                </div> 
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="count-wrap">
                        <div class="col-sm-3 col-xs-6">
                            <i class="fa fa-flask"></i>
                            <h3 class="timer">7</h3>
                            <p>Years of Experience</p>
                        </div>
                        <div class="col-sm-3 col-xs-6"> 
                            <i class="fa fa-thumbs-up"></i>
                            <h3 class="timer">651</h3>                
                            <p>Projects Done</p>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <i class="fa fa-users"></i>
                            <h3 class="timer">251</h3> 
                            <p>Happy Clients</p>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <i class="fa fa-trophy"></i>
                            <h3 class="timer">5</h3> 
                            <p>Awards Won</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <h2>Get in touch</h2>
            <div class="row">
                <div class="col-md-6">
                    <strong>Send me a message</strong>
                    <form name="contact" id="contact" action="sendemail.php" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" required="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required="">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" class="form-control" id="subject">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" class="form-control" id="message" rows="5" required=""></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="row center-xs">
                        <div class="col-sm-6">
                            <i class="fa fa-map-marker"></i>
                            <address>
                                <strong>Address/Street:</strong>
                                <p>239/2 Awesome Street, Boston, USA</p>
                            </address>
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-mobile"></i>
                            <div class="contact-number">
                                <strong>Phone Number:</strong>
                                <P>Email me First!</P>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>