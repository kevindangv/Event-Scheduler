<?php
/* Kevin Dang kd9me - Jennifer Huynh jph5au */

    require('connect-db.php');

    session_start();

    $curr_username = $_SESSION['username'];


    include 'Calendar.php';
    $curr_date = date('Y-m-d', strtotime(' -1 day'));
    $calendar = new Calendar($curr_date);

    function getEvent() {
        global $curr_username;
        global $calendar;
        global $db;

        $query = "SELECT * FROM users WHERE username='$curr_username'";

        $statement = $db->prepare($query);

        $statement->execute();

        $results = $statement->fetch();
        $curruser_id = $results['id'];

        $query = "SELECT * FROM events WHERE curruserid = $curruser_id";

        $statement = $db->prepare($query);
    
        $statement->execute();

        $results = $statement->fetchAll();

        foreach($results as $result)
            $calendar->add_event($result['eventname'], $result['eventtime'], $result['eventdays'], $result['eventcolor']);
    }

    function insertEvent() {
        global $curr_username;
        global $db;

        $query = "SELECT * FROM users WHERE username='$curr_username'";

        $statement = $db->prepare($query);

        $statement->execute();

        $results = $statement->fetch();

        //echo $results['id'];

        $eventname_form = $_POST["eventname"];
        $eventtime_form = $_POST["eventtime"];
        $eventdays_form = $_POST["eventdays"];
        $eventcolor_form = 'green';
        $curruser_id = $results['id'];
        
        $query = "INSERT INTO events (eventName, eventTime, eventDays, eventColor, curruserID) VALUES (:eventname, :eventtime, :eventdays, :eventcolor, :curruserid)";

        $statement = $db->prepare($query);

        $statement->bindValue(':eventname', $eventname_form);
        $statement->bindValue(':eventtime', $eventtime_form);
        $statement->bindValue(':eventdays', $eventdays_form);
        $statement->bindValue(':eventcolor', $eventcolor_form);
        $statement->bindValue(':curruserid', $curruser_id);

        $statement->execute();
    }

    function deleteEvent() {
        global $db;

        $eventname_form = $_POST['deletename'];

        $query = "DELETE FROM events WHERE eventname='$eventname_form'";

        $statement = $db->prepare($query);
        $statement->execute();
    }

    if(isset($_POST['deletesubmit'])) {
        deleteEvent();
    }

    if(isset($_POST['submit'])) {
        insertEvent();
    }

    if(isset($_POST['submitmeeting'])) {
        $calendar->add_event($_POST["meetingtitle"], $_POST["meetingtime"], (int)$_POST["meetingdays"], 'yellow');
    }

    if(isset($_POST['signout'])) {
        // Initialize the session
        session_start();

        // Unset all of the session variables
        $_SESSION = array();

        // Destroy the session.
        session_destroy();

        // Redirect to login page
        header("location: login.php");
        exit;
    }
    getEvent();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Event Calendar</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="calendar.css" rel="stylesheet" type="text/css">
    <script src="scripts.js"></script>
</head>

<body>
    <header>
        <nav>
            <ul class="nav_links">
                <button id="deleteButton" onclick="deleteModal()">Delete Event</button>
                <div id="deleteModal" class="modal">
                    <form class="modal-content" method="post">
                        <span class="close"></span>
                        <label for="dname"><a>Event Title</a></label>
                        <input type="text" id="dname" name="deletename" placeholder="Event name">

                        <input type="submit" value="Submit" name="deletesubmit">
                    </form>
                </div>

                <button id="eventButton" onclick="eventModal()">Create Event</button>
                <div id="eventModal" class="modal">
                    <!-- Modal content -->
                    <form class="modal-content" method="post">
                        <span class="close"></span>
                        <label for="ename"><a>Event Title</a></label>
                        <input type="text" id="ename" name="eventname" placeholder="Event name">

                        <label for="time"><a>Date</a></label>
                        <input type="text" id="time" name="eventtime" placeholder="Time">

                        <label for="time"><a>Days</a></label>
                        <input type="text" id="time" name="eventdays" placeholder="Days">

                        <!--
                        <label for="share"><a>Share</a></label>
                        <select id="share" name="share">
                            <option value="PTA"><a>PTA</a></option>
                            <option value="work"><a>Work</a></option>
                            <option value="family"><a>Family</a></option>
                        </select>
                        -->

                        <input type="submit" value="Submit" name="submit">
                    </form>
                </div>

                <button id="meetingButton" onclick="meetingModal()">Create Meeting</button>
                <div id="meetingModal" class="modal">
                    <!-- Meeting modal content -->
                    <form class="modal-content" method="post">
                        <span class="close"></span>
                        <label for="mtitle"><a>Meeting Title</a></label>
                        <input type="text" id="mtime" name="meetingtitle" placeholder="Meeting Title">

                        <label for="time"><a>Date</a></label>
                        <input type="text" id="time" name="meetingtime" placeholder="Time">

                        <label for="time"><a>Days</a></label>
                        <input type="text" id="time" name="meetingdays" placeholder="Days">

                        <input type="submit" value="Submit" name="submitmeeting">
                    </form>
                </div>

                <button name="userButton" id="userButton" value=>John Smith</button>

                <button style="margin-top:10px">
                <form method="post" style="height:14px">
                    <input type="submit" value="Sign Out" name="signout" style="padding:0">
                </form>
                </button>
            </ul>
        </nav>
    </header>
    <div class="content home">
        <?=$calendar?>
    </div>
</body>

</html>