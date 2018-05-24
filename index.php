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
        <div class="home" id="home">
            <h1 class="title">LachlanB</h1>
            <div class="content">
                <div class="text">
                    <?=$homeSubtitle?>
                </div>
                <div class="box-list">
                    <? foreach ($homeIcons as $icon => $link): ?>
                        <a href=<?=$link?>><div class="item <?=$icon?>"></div></a>
                    <? endforeach ?>   
                </div>
                <i class="fas fa-angle-double-down fa-2x"></i>
            </div>
        </div>
    </div>

    <div class="section section-dark">
        <nav class="navbar navbar-static-top navbar-default navbar-inverse">
            <div class="nav navbar-nav">
                <? foreach ($sections as $section): ?>
                    <li id="<?=$section?>Nav" class="not-active">
                        <a href="#<?=$section?>">
                            <div class="item">
                                <?=$section?>
                            </div>
                        </a>
                    </li>
                <? endforeach ?>   
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
                        <?=$aboutMe_objective?>
                    </div>
                    <h3 class="heading">What I Do?</h3>
                    <div class="text">
                        <?=$aboutMe_whatIDo?>
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
                    <? foreach ($whatIDo as $workTask): ?>
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
                    <? endforeach ?>
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
        <div class="skills" id="skills">
            <h2 class="title">Skills</h2>
            <div class="content row">
                <?$colours = ['danger', 'success', 'info', 'warning']; ?>
                <?foreach($skills as $skill => $attributes): ?>
                    <h3><?=$skill?></h3>
                    <div class="progress" id="<?=$skill?>" onclick="doThis('<?=$skill?>')">
                        <? foreach($attributes as $attr => $value): ?>
                            <div class="progress-bar progress-bar-<?=$colours[$value['colour']]?>" style="width: <?=$value['amount']?>%">
                                <p><?=$attr?></p>
                            </div>
                        <? endforeach ?>
                    </div>
                    <?foreach($attributes as $attr => $value): ?>
                        <h4 style="text-align: center;"><?=$attr?></h4>
                        <div class="sub<?=$skill?> progress" id="sub<?=$skill?>" style="display:none;">
                            <?$colour = $value['amount'] < 10 ? 0 : ($value['amount'] < 25 ? 3 : ($value['amount'] < 35 ? 2 : 1))?> 
                            <?=$colour?>
                            <div class="progress-bar progress-bar-<?=$colours[$colour]?>" style="width: <?=$value['amount']?>%">iou
                            </div>
                        </div>
                    <? endforeach ?>
                <? endforeach ?>
            </div>
        </div>
        <br />
        <br />
        <br />
        <br />
        <br />
    </div>

    <div class="section">
        <div class="past">
            <h2 class="title">Experience</h2>
            <div class="content row">
                <div class="left"></div>
                <div class="timeline">
                    <div class="event left">
                        <div class="information">
                            <div class="date">
                                2008-2014
                            </div>
                            <div class="heading">
                                Second Education
                            </div>
                            <p>Attended Caringbah Selective High School</p>
                            <p>Obtained remarkable marks such as: <br />
                                &bull;Band 6 – Software Design and Development<br />
                                &bull;Band 6 – Design and Technology<br />
                                &bull;Band 6 – Talented Computing Program<br />
                            &bull;Band 5 – Information Processes Technology</p>
                        </div>
                    </div>
                    <div class="event right" style="display: block">
                        <div class="information">
                            <div class="date">
                                2015-2018
                            </div>
                            <div class="heading">
                                Tertiary Education
                            </div>
                            <p>Attended Caringbah Selective High School</p>
                            <p>Obtained remarkable marks such as:<br />
                                &bull;Band 6 – Software Design and Development<br />
                                &bull;Band 6 – Design and Technology<br />
                                &bull;Band 6 – Talented Computing Program<br />
                            &bull;Band 5 – Information Processes Technology</p>
                            <p>Lorem ipsasdsdasdaum..</p>
                        </div>
                    </div>
                    <div class="event left" style="display: block">
                        <div class="information">
                            <div class="date">2005</div>
                            <div class="heading">
                                Tertiary Education
                            </div>
                            <p>Lorem ipsum..</p>
                        </div>
                    </div>
                    <div class="event right">
                        <div class="information">
                            <div class="date">2005</div>
                            <div class="heading">
                                Tertiary Education
                            </div>
                            <p>Lorem ipsum..</p>
                        </div>
                    </div>
                </div>
                <div class="right"></div>
            </div>
        </div>
    </div>


    <a id="achievements"></a>
    <div class="section section-dark">
        <div class="achievements">
            <h2 class="title">Achievements</h2>
            <div class="content row">
                <div class="col-md-12">
                    <div class="group">
                        <div class="number">4</div>
                        <div class="fa fa-flask fa-3x"></div>
                        <div class="text">Years of Experience</div>
                    </div>
                    <div class="group"> 
                        <div class="number">21</div>
                        <div class="fa fa-thumbs-up fa-3x"></div>                
                        <div class="text">Public Repositories</div>
                    </div>
                    <div class="group">
                        <div class="number">10</div>
                        <div class="fa fa-users fa-3x"></div> 
                        <div class="text">Languages Learnt</div>
                    </div>
                    <div class="group">
                        <div class="number">5</div>
                        <div class="fa fa-trophy fa-3x"></div> 
                        <div class="text">Awards Won</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="contact" name="contact">
            <h2 class="title">Get in Touch</h2>
            <div class="content row">
                <div class="col-md-6 striked-out">
                    <h3 class="heading">Send me a message</h3>
                    <form name="contact">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" class="form-control" rows="5" disabled></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-disabled">Send Message</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="row center-xs">
                        <div class="col-sm-6">
                            <i class="fa fa-map-marker"></i>
                            <address>
                                <strong>Current Location:</strong>
                                <p>Cronulla Beach, as well as Sydney CBD on most weekdays</p>
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
                    <div class="content row formHover">
                        As a web designer, I feel that these "send me a message" modules never work. I tried testing a very popular one, but to the majorities of its users and my non-suprise, most complained that it did not work due to problem X, Y, Z, A, B, etc. So I decided to just include a mailto URI to contact me. Please press the button to generate my email address (this is to avoid web scrapers spamming the mail)
                        <button type="button" id="emailButton" class="btn btn-success btn-block">Reveal eMail</button>
                        <div id="emailPlain"></div>
                        <div id="mailTo" style="display: none"><a>Click me for a faster experience!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>