<?
require_once('elevator/elevator.php');
use lift;

$elevator_settings = array(
				'acceleration' => 0.5,  			// 	(m/sec2)
				'deceleration' => 0.4,  			// 	(m/sec2)
				'speedUp' => 1,						// 	speed when going up (m/s)
				'speedDown' => 1.2,					// 	speed when going down (m/s)
				'floorHeight' => 3,					// 	floor height (m)
				'maxPassengersWeight' => 500,   	// 	max permitted passengers weight (kg)	
			);
			
$elevator = new lift\Elevator($elevator_settings);
$elevator->setDefaultFloor(1);
$elevator->setDefaultTime(date("00:00:00"));



/*
Jim
Will wait for the elevator for 130 seconds
weight: 150 kg
Is getting into (out of) the cabin for 6 seconds
Is going from 7 to 1 floor
*/
$passenger_1 = new lift\Passenger('Jim', 130, 150, 6); 
$passenger_1->call(date("00:02:03"), 7);
$passenger_1->goesTo(1);
$elevator->add($passenger_1);



/*
Bob
Will wait for the elevator for 130 seconds
weight: 90 kg
Is getting into (out of) the cabin for 6 seconds
Is going from 7 to 10 floor
*/
$passenger_2 = new lift\Passenger('Bob', 130, 90, 6); 
$passenger_2->call(date("00:02:03"), 7);
$passenger_2->goesTo(10);
$elevator->add($passenger_2);

/*
Joe
Will wait for the elevator for 100 seconds
weight: 70 kg
Is getting into (out of) the cabin for 2 seconds
Is going from 10 to 2 floor
*/
$passenger_3 = new lift\Passenger('Joe', 100, 70, 2); 
$passenger_3->call(date("00:02:07"), 10, 2);
$passenger_3->goesTo(2);
$elevator->add($passenger_3);

/*
Prankster
Will wait for the elevator for 500 seconds
calling from 44 floor
*/
$prankster_1 = new lift\Prankster('Nick', 500); 
$prankster_1->call(date("00:02:05"), 44);
$elevator->add($prankster_1);

/*
Kate
Will wait for the elevator for 130 seconds
weight: 50 kg
Is getting into (out of) the cabin for 3 seconds
Is going from 4 to 1 floor
*/
$passenger_4 = new lift\Passenger('Kate', 130, 50, 3); 
$passenger_4->call(date("00:02:05"), 4, 1);
$passenger_4->goesTo(1);
$elevator->add($passenger_4);

$elevator->move();
?>


