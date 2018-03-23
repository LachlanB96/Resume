<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Lachlan, Brown, LachlanB, LachlanB.com, Lachlanb.net. LachlanB.org, LachlanB.com.au, Software Developer, Software, Engineer, Architect, Resume, CV, Ethereum, Blockchain, Ether, Bitcoin, Website, Solidity, Smart Contracts, Smart, Contract">
    <title>About LachlanB</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Roboto" rel="stylesheet">
    <script src="js/fontawesome-all.js"></script>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/scripts.js"></script>
</head>
<body>

    <?php

    include 'data.php';

    $x = 0;

    ?>

    

    <div class="section">
        <div class="home">
            <h1 class="title">LachlanB</h1>
            <div class="content">
                <div class="text">
                    <?=$homeSubtitle?>
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

    <div class="section section-dark">
        <nav class="navbar navbar-static-top navbar-default navbar-inverse">
            <div class="nav navbar-nav">
                <?php foreach ($sections as $section) { ?>
                <li id="<?=$section?>" class="not-active">
                    <a href="#<?=$section?>">
                        <div class="item">
                            <?=$section?>
                        </div>
                    </a>
                </li>
                <?php } ?>   
            </div>
        </nav>
    </div>

    <div class="section">
        <div class="about">
            <h2 class="title">About Me</h2>
            <div class="content row">
                <div class="col-md-8">
                    <h3 class="heading">Objective</h3>
                    <div class="text">
                        <p>An opportunity to work and upgrade oneself, as well as being involved in an organization that believes in gaining a competitive edge and giving back to the community. I'm presently expanding my solid experience in UI / UX design. I focus on using my interpersonal skills to build good user experience and create a strong interest in my employers. I hope to develop skills in motion design and my knowledge of the Web, and become an honest asset to the business. As an individual, I'm self-confident you’ll find me creative, funny and naturally passionate. I’m a forward thinker, which others may find inspiring when working as a team.</p>
                    </div>
                    <h3 class="heading">What I Do?</h3>
                    <div class="text">
                        I have been working as a web interface designer since. I have a love of clean, elegant styling, and I have lots of experience in the production of CSS3 and HTML5 for modern websites. I loving creating awesome as per my clients’ need. I think user experience when I try to craft something for my clients. Making a design awesome.
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="biography">
                        <div class="image">
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
            <div class="content content-center-half row">
                <div class="list">
                    <?php foreach ($whatIDo as $workTask) { ?>
                    <div class="item">
                        <div class="col-md-2">
                            <div class="icon <?=$workTask['icon']?>"></div>
                        </div>
                        <div class="col-md-10">
                            <h3 class="heading"><?=$workTask['name']?></h3>
                            <div class="text">
                                <?=$workTask['description']?> 
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="content row">
                <div class="input">
                    <div class="btn btn-info btn-lg" href="#contact"><i class="fa fa-paper-plane"></i>Send me message</div>
                    <div class="btn btn-primary btn-lg" href="#"><i class="fa fa-download"></i>download my cv</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-dark">
        <div class="skills" id="#skills">
            <h2 class="title">Skills</h2>
            <div class="content row">
                <?php
                echo '<div class="col-md-6">';
                $skillsIndex = 0;
                $skillsLength = count($skills)/2;
                foreach($skills as $heading => $attributes) {
                    if($skillsIndex == $skillsLength){
                        echo '</div>';
                        echo '<div class="col-md-6">';
                    }
                    echo '<h3>'.$heading.'</h3>';
                    echo '<div class="progress">';
                    foreach($attributes as $attr => $value) {
                        echo '<div class="progress-bar" style="width:'.$value.'%">';
                        echo '<p>'.$attr.'</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                    $skillsIndex++;
                } 
                echo '</div>';
                ?>
            </div>
        </div>
        <div class="content row">
            <h3 class="heading">More skills</h3>
            <div class="list">
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
        <div class="resume">
            <h2 class="title">Resume</h2>
            <div class="content row">
                <div class="col-md-12">
                    <h3 class="heading">Education</h3>
                    <div class="list">
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
                    </div>
                    <div class="list">
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
                    </div>
                </div>
            </div>
            <div class="content row">
                <div class="col-md-12">
                    <h3 class="heading">Experience</h3>
                    <div class="list">
                        <ul>
                            <li>
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
    </div>

    <div class="section section-dark">
        <div class="achievements">
            <h2 class="title">Achievements</h2>
            <div class="content row">
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
        <div class="contact">
            <h2 class="title">Get in Touch</h2>
            <div class="content row">
                <div class="col-md-6">
                    <h3 class="heading">Send me a message</h3>
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