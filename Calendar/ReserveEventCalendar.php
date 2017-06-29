<?php
include '..'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Noms'.DIRECTORY_SEPARATOR.'NomDegrees.php';
include '..'.DIRECTORY_SEPARATOR.'header.php';

?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../style/main.css" type="text/css"/>
		<link type="text/css" href="../scripts/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
		<script type="text/JavaScript" src="../scripts/jquery-3.2.1.js"></script>
		<script type="text/JavaScript" src="../scripts/UserJQueryMessageStyles.js"></script>
		<script type="text/JavaScript" src="../scripts/DatePicker.js"></script>
		<script type="text/javascript" src="../scripts/jquery-ui-1.12.1/jquery-ui.js"></script>
		<title>Календар</title>
	</head>
	<body>
		<div id="calendar-main">            
			<div class="month">
				<h1>Август 2014</h1>            
			</div>            
			<div id="calendar">                
				<ul class="weekdays">                    
					<li>Понеделник</li>                    
					<li>Вторник</li>                    
					<li>Сряда</li>                    
					<li>Четвъртък</li>                    
					<li>Петък</li>                    
					<li>Събота</li>                    
					<li>Неделя</li>                
				</ul>                
				<!-- Days from previous month -->                
				<ul class="days">                    
					<li class="day other-month">                        
						<div class="date">27</div>                                          
					</li>                    
					<li class="day other-month">                        
						<div class="date">28</div>                        
						<div class="event">
							<div class="event-time">1:00-3:00</div>
							<div class="event-desc">HTML 5 lecture with Brad Traversy from Eduonix</div>
						</div>                                          
					</li>                    
					<li class="day other-month">                        
						<div class="date">29</div>                                          
					</li>                    
					<li class="day other-month">                        
						<div class="date">30</div>                                          
					</li>                    
					<li class="day other-month">                        
						<div class="date">31</div>                                          
					</li>                    
					<!-- Days in current month -->                    
					<li class="day">                        
						<div class="date">1</div>                                           
					</li>                    
					<li class="day">                        
						<div class="date">2</div>                        
						<div class="event">
							<div class="event-time">2:00-5:00</div>
							<div class="event-desc">Career development @ Community College room #402</div>
						</div>                                          
					</li>                
				</ul>                    
				<!-- Row #2 -->                
				<ul class="days">                    
					<li class="day">                        
						<div class="date">3</div>                                           
					</li>                    
					<li class="day">                        
						<div class="date">4</div>                                           
					</li>                    
					<li class="day">                        
						<div class="date">5</div>                                           
					</li>                    
					<li class="day">                        
						<div class="date">6</div>                                           
					</li>                    
					<li class="day">                        
						<div class="date">7</div>                        
						<div class="event">
							<div class="event-time">6:00-8:30</div>
							<div class="event-desc">Group Project meetup</div>
						</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">8</div>                                           
					</li>                    
					<li class="day">                        
						<div class="date">9</div>                                           
					</li>                
				</ul>                    
				<!-- Row #3 -->                
				<ul class="days">
					<li class="day">
						<div class="date">10</div>
					</li>
					<li class="day">
						<div class="date">11</div>
					</li>
					<li class="day">
						<div class="date">12</div>
					</li>
					<li class="day">
						<div class="date">13</div>
					</li>
					<li class="day">
						<div class="date">14</div>
						<div class="event">
							<div class="event-time">1:00-3:00</div>
							<div class="event-desc">Board Meeting</div>
						</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">15</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">16</div>                                          
					</li>                
				</ul>                    
				<!-- Row #4 -->                
				<ul class="days">                    
					<li class="day">                        
						<div class="date">17</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">18</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">19</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">20</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">21</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">22</div>                        
						<div class="event">
							<div class="event-time">9:00-12:00</div>
							<div class="event-desc">Conference call</div>
						</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">23</div>                                          
					</li>                
				</ul>                        
				<!-- Row #5 -->                
				<ul class="days">                    
					<li class="day">                        
						<div class="date">24</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">25</div>                        
						<div class="event">
							<div class="event-time">1:00-3:00</div>
							<div class="event-desc">Conference Call</div>
						</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">26</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">27</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">28</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">29</div>                                          
					</li>                    
					<li class="day">                        
						<div class="date">30</div>                                          
					</li>                
				</ul>                
				<!-- Row #6 -->                
				<ul class="days">                    
					<li class="day">                        
						<div class="date">31</div>                                          
					</li>                         
					<!-- Next Month --> 
					<li class="day other-month">                        
						<div class="date">1</div>                                          
					</li>                
					<li class="day other-month">                        
						<div class="date">2</div>                                           
					</li>                    
					<li class="day other-month">                        
						<div class="date">3</div>                                           
					</li>                    
					<li class="day other-month">                        
						<div class="date">4</div>                                           
					</li>                    
					<li class="day other-month">                        
						<div class="date">5</div>                                           
					</li>                    
					<li class="day other-month">                        
						<div class="date">6</div>                                           
					</li>                
				</ul>            
			</div><!-- /. calendar -->        
		</div><!-- /. wrap -->
	</body>
</html>