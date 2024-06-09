@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-black text-center" style="display: flex; flex-direction: row; align-items: center; justify-content: center;">
                <h3 class="mb-0">{{ __('Create Region and Commune') }}</h3>
            </div>

            <div class="bg-light p-4" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <p class="lead mb-4">{{ __('Before creating an account, we need to create a region and commune.') }}</p>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <button type="button" id="showCreateRegion" class="btn btn-success btn-block">
                            <i class="fas fa-map-marker-alt mr-2"></i>{{ __('Create Region') }}
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a href="#" id="showCreateCommune" class="btn btn-success btn-block" style="min-width: 165px; max-width: 240px">
                            <i class="fas fa-city mr-2"></i>{{ __('Create Commune') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#showCreateRegion').click(function(e) {
            e.preventDefault(); // Prevent the default action of following the href
            // Use Ajax or any other method to load the CreateRegion view and display it
            // For example, using Ajax:
            $.ajax({
                url: '{{ route("region.store") }}', // Adjust the route to your region creation route
                type: 'POST',
                success: function(response) {
                    // Assuming 'response' contains the HTML content of the CreateRegion view
                    $('#container').html(response); // Display the CreateRegion view in a container
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        $('#showCreateCommune').click(function(e) {
            e.preventDefault(); // Prevent the default action of following the href
            // Use Ajax or any other method to load the CreateCommune view and display it
            // For example, using Ajax:
            $.ajax({
                url: '{{ route("commune.store") }}', // Adjust the route to your commune creation route
                type: 'GET',
                success: function(response) {
                    // Assuming 'response' contains the HTML content of the CreateCommune view
                    $('#container').html(response); // Display the CreateCommune view in a container
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        $('#showRegions').click(function(e) {
            e.preventDefault(); // Prevent the default action of following the href
            // Use Ajax or any other method to load the CreateCommune view and display it
            // For example, using Ajax:
            $.ajax({
                url: '{{ route("regions.show") }}', // Adjust the route to your commune creation route
                type: 'GET',
                success: function(response) {
                    // Assuming 'response' contains the HTML content of the CreateCommune view
                    $('#container').html(response); // Display the CreateCommune view in a container
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });

</script>
<script>

</script>

@endsection