<!doctype html>
<html lang="en">
<head>
<title>PHP Google Autocomplete Address Example</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-5">
<div class="row">
<div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12 m-auto">
<div class="card shadow">
<div class="card-header bg-primary">
<h5 class="card-title text-white">PHP Google Autocomplete Address</h5>
</div>
<div class="card-body">
<div class="form-group">
<label for="autocomplete"> Location/City/Address </label>
<input type="text" name="autocomplete" id="autocomplete" class="form-control" placeholder="Select Location">
</div>
<div class="form-group" id="lat_area">
<label for="latitude"> Latitude </label>
<input type="text" name="latitude" id="latitude" class="form-control">
</div>
<div class="form-group" id="long_area">
<label for="latitude"> Longitude </label>
<input type="text" name="longitude" id="longitude" class="form-control">
</div>
</div>
</div>
</div>
</div>
</div>

<script src="https://maps.google.com/maps/api/js?key=AIzaSyCwpns7FoF40IUPN4ianDrtxsOY9zR0RwE&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script src="address.js"></script>
</body>
</html>