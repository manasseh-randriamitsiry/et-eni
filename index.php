<?php
require_once('bdd.php');


$sql = "SELECT id, title, start, end, color,salle,enseignant FROM events ";

$req = $bdd->prepare($sql);
$req->execute();

$events = $req->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestion d'emploie du temps</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- FullCalendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />


    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 5%;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
	#calendar {
		max-width: 90%;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
    </style>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="ico-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Emploie du temps</a>
            </div>
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="text-center">
                <!-- Add this div for error message display -->
                <div id="errorMessage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Error</h4>
                            </div>
                            <div class="modal-body">
                                <p id="errorText"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="calendar" class="col-centered">

                </div>
            </div>
        </div>
		
		<!-- Modal -->
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="addEvent.php">
			
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Ajout evenement</h4>
			  </div>
			  <div class="modal-body">
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Titre</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control" id="title" placeholder="Titre">
					</div>
				  </div>
                  <div class="form-group">
                      <label for="enseignant" class="col-sm-2 control-label">Enseignant:</label>
                      <div class="col-sm-10">
                          <input type="text" name="enseignant" class="form-control" id="enseignant" placeholder="Enseignant">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="salle" class="col-sm-2 control-label">Salle:</label>
                      <div class="col-sm-10">
                          <input type="text" name="salle" class="form-control" id="Salle" placeholder="Salle">
                      </div>
                  </div>
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Debut:</label>
					<div class="col-sm-10">
					  <input type="datetime-local" name="start" class="form-control" id="start" required>
					</div>
				  </div>
				  <div class="form-group">
					<label for="end" class="col-sm-2 control-label">Fin:</label>
					<div class="col-sm-10">
					  <input type="datetime-local" name="end" class="form-control" id="end" required >
					</div>
				  </div>
                  <div class="form-group">
                      <label for="color" class="col-sm-2 control-label">Couleur</label>
                      <div class="col-sm-10">
                          <input type="color" name="color" id="color"  class="form-control" style="border: none">
                      </div>
                  </div>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="editEvent.php">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Mode editer</h4>
			  </div>
			  <div class="modal-body">
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Titre</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control" id="title" placeholder="Title">
					</div>
				  </div>
                  <div class="form-group">
                      <label for="enseignant_edit" class="col-sm-2 control-label">Enseignant:</label>
                      <div class="col-sm-10">
                          <input type="text" name="enseignant" class="form-control" id="enseignant" placeholder="Enseignant">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="salle_edit" class="col-sm-2 control-label">Salle:</label>
                      <div class="col-sm-10">
                          <input type="text" name="salle" class="form-control" id="salle" placeholder="Salle">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="start" class="col-sm-2 control-label">Debut:</label>
                      <div class="col-sm-10">
                          <input type="datetime-local" name="start" class="form-control" id="start">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="end" class="col-sm-2 control-label">Fin:</label>
                      <div class="col-sm-10">
                          <input type="datetime-local" name="end" class="form-control" id="end">
                      </div>
                  </div>
				  <div class="form-group">
					<label for="color" class="col-sm-2 control-label">Coleur</label>
					<div class="col-sm-10">
                        <input type="color" name="color" id="color"  class="form-control" style="border: none">
					</div>
				  </div>

				  <input type="hidden" name="id" class="form-control" id="id">
			  </div>
			  <div class="modal-footer">
				<button type="submit" class="btn btn-primary">Sauvegarder</button>
                  <button type="submit" name="delete" class="btn btn-danger">Supprimer</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="dist/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="dist/js/bootstrap.min.js"></script>
	
	<!-- FullCalendar -->
	<script src='dist/js/moment.min.js'></script>
	<script src='dist/js/fullcalendar.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js" integrity="sha256-GBryZPfVv8G3K1Lu2QwcqQXAO4Szv4xlY4B/ftvyoMI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.js" integrity="sha256-FT1eN+60LmWX0J8P25UuTjEEE0ZYvpC07nnU6oFKFuI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/interaction/main.min.js" integrity="sha256-MUHmW5oHmLLsvmMWBO8gVtKYrjVwUSFau6pRXu8dtnA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/timegrid/main.min.js" integrity="sha256-L9T+qE3Ms6Rsuxl+KwLST6a3R/2o6m33zB5mR2KyPjU=" crossorigin="anonymous"></script>


    <script>

	$(document).ready(function() {

        var errorMessage = "<?php echo isset($_GET['error']) ? $_GET['error'] : ''; ?>";

        // If there is an error message, display it in the modal
        if (errorMessage !== "") {
            $('#errorText').text(errorMessage);
            $('#errorMessage').modal('show');
        }

		$('#calendar').fullCalendar({
            plugins: [ 'dayGrid',
                'interaction',
                'timeGrid'
            ],
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
            timeFormat: 'H(:mm)', // uppercase H for 24-hour clock
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
            AllDayDefault: false,
            select: function(start, end) {
                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DDTHH:mm:ss'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DDTHH:mm:ss'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function(event, element) {
                element.bind('click', function() {
                    $('#ModalEdit #id').val(event.id);
                    $('#ModalEdit #title').val(event.title);
                    $('#ModalEdit #salle').val(event.salle);
                    $('#ModalEdit #enseignant').val(event.enseignant);
                    $('#ModalEdit #color').val(event.color);
                    var rgbaColor = hexToRGBA(event.color, 0.4);
                    $('#ModalEdit .modal-content').css('background-color', rgbaColor);
                    $('#ModalEdit #start').val(moment(event.start).format('YYYY-MM-DDTHH:mm:ss'));
                    $('#ModalEdit #end').val(moment(event.end).format('YYYY-MM-DDTHH:mm:ss'));
                    $('#ModalEdit').modal('show');
                });
                element.find('.fc-title').append("<br/> Prof: " + event.enseignant);
                element.find('.fc-title').append("<br/> Salle: " + event.salle);
            },

			eventDrop: function(event, delta, revertFunc) { // si changement de position
				edit(event);
			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur
				edit(event);
			},
			events: [
			<?php foreach($events as $event):

				$start = explode(" ", $event['start']);
				$end = explode(" ", $event['end']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['start'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['end'];
				}
			?>
				{
					id: '<?php echo $event['id']; ?>',
					title: '<?php echo $event['title']; ?>',
					salle: '<?php echo $event['salle']; ?>',
					enseignant: '<?php echo $event['enseignant']; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					color: '<?php echo $event['color']; ?>',
				},

			<?php endforeach; ?>
			]
		});

        function hexToRGBA(hex, alpha) {
            var r = parseInt(hex.slice(1, 3), 16),
                g = parseInt(hex.slice(3, 5), 16),
                b = parseInt(hex.slice(5, 7), 16);

            return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + alpha + ')';
        }

		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}

			id =  event.id;
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;

			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep != 'OK'){
                        alert('Could not be saved. try again.');
                    }
				}
			});
		}
	});


    </script>



</body>

</html>
