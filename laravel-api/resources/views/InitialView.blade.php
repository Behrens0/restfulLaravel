@extends('layouts.app')

@section('dynamic-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    .pagination .page-link {
        padding: 0.2rem 0.4rem; /* Adjust the padding to make arrows smaller */
        font-size: 0.8rem; /* Adjust the font size to make the arrows smaller */
    }
    .pagination .page-item .page-link .w-5.h-5 {
        width: 0.2rem; /* Adjust the width to make the SVG smaller */
        height: 0.2rem; /* Adjust the height to make the SVG smaller */
    }
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        border-radius: 0.2rem; /* Adjust border-radius if needed */
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-black text-center" style="display: flex; flex-direction: row; align-items: center; justify-content: center;">
                <h3 class="mb-0">{{ __('Create Region and Commune') }}</h3>
            </div>

            <div class="bg-light p-4" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <p class="lead mb-4">{{ __('Before creating an account, we need to create a region and a commune.') }}</p>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <button type="button" id="showCreateRegion" class="btn btn-primary btn-block">
                            <i class="fas fa-map-marker-alt mr-2"></i>{{ __('Create Region') }}
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a href="#" id="showCreateCommune" class="btn btn-primary btn-block" style="min-width: 165px; max-width: 240px">
                            <i class="fas fa-city mr-2"></i>{{ __('Create Commune') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <!-- Display Regions -->
            <h4>Regions:</h4>
            @if ($regions->isEmpty())
                <p>No regions found.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($regions as $region)
                            <tr>
                                <td>{{ $region->id_reg }}</td>
                                <td>{{ $region->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                {{ $regions->links() }}
            @endif
        </div>
        
        <div class="col-md-6">
            <!-- Display Communes -->
            <h4>Communes:</h4>
            @if ($communes->isEmpty())
                <p>No communes found.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Region ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($communes as $commune)
                            <tr>
                                <td>{{ $commune->id_com }}</td>
                                <td>{{ $commune->description }}</td>
                                <td>{{ $commune->id_reg }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                {{ $communes->links() }}
            @endif
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
@include('modals')

<script>
    $(document).ready(function() {
        // Show modal on button click
        $('#showCreateRegion').click(function () {
            $('#createRegionModal').modal('show');
        });

        $('#showCreateCommune').click(function () {
            $('#createCommuneModal').modal('show');
        });

        // Handle form submission for Create Region
        $('#saveRegionBtn').click(function () {
            $.ajax({
                url: '{{ route("region.store") }}', // Adjust the route to your region creation route
                type: 'POST',
                data: $('#createRegionForm').serialize(),
                success: function(response) {
                    // Close the modal
                    $('#createRegionModal').modal('hide');
                    // Optionally, refresh the regions list or give feedback to the user
                    updateRegions();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        // Handle form submission for Create Commune
        $('#saveCommuneBtn').click(function () {
            $.ajax({
                url: '{{ route("commune.store") }}', // Adjust the route to your commune creation route
                type: 'POST',
                data: $('#createCommuneForm').serialize(),
                success: function(response) {
                    // Close the modal
                    $('#createCommuneModal').modal('hide');
                    // Optionally, refresh the communes list or give feedback to the user
                    updateCommunes();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        // Function to update the list of regions
        function updateRegions() {
            $.ajax({
                url: '{{ route("regions.index") }}', // Adjust the route to your regions index route
                type: 'GET',
                success: function(data) {
                    // Update the HTML content of the regions list
                    $('#regionsList').html(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    });
</script>

@endsection