@extends('layouts.app')

@section('dynamic-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    .pagination .page-link {
        padding: 0.2rem 0.4rem;
        font-size: 0.8rem;
    }
    .pagination .page-item .page-link .w-5.h-5 {
        width: 0.2rem;
        height: 0.2rem;
    }
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        border-radius: 0.2rem;
    }
    .table-container {
        margin-left: -15px;
    }
    .btn-block {
        width: auto;
    }
    .bg-light {
        padding: 1rem !important;
    }
    .btn-sm {
        padding: 0.15rem 0.2rem !important;
        font-size: 0.875rem !important;
    }
    .create-customer-container {
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
        align-items: center;
        width: 100%;
    }
    .create-customer-btn {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
    .search-container {
        display: flex;
        align-items: center;
    }
    .search-input {
        padding: 0.5rem;
        font-size: 1rem;
        margin-right: 10px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-black bg-light p-2" style="display: flex; flex-direction: row; align-items: center; justify-content: center;">
                <h3 class="mb-0">{{ __('Customers') }}</h3>
            </div>
        </div>
    </div>

    <div class="row create-customer-container">
        <button type="button" id="showCreateCustomer" class="btn btn-primary create-customer-btn">
            <i class="fas fa-user mr-2"></i>{{ __('Create Customer') }}
        </button>
        <div class="search-container">
            <input type="text" id="searchInput" class="form-control search-input" placeholder="Search...">
            <button type="button" id="searchButton" class="btn btn-primary search-btn">
                <i class="fas fa-search mr-2"></i>{{ __('Search') }}
            </button>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-12 table-container">
            <h4>Customers:</h4>
            <div id="customersList">
                @if ($customers->isEmpty())
                    <p>No Customers found.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>DNI</th>
                                <th>Region</th>
                                <th>Commune</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr data-email="{{ $customer->email }}">
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->last_name }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->dni }}</td>
                                    <td>{{ $customer->id_reg }}</td>
                                    <td>{{ $customer->id_com }}</td>
                                    <td>
                                        <button class="btn btn-danger delete-btn" data-email="{{ $customer->email }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $customers->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
@include('customerModal')
<script>
    $(document).ready(function() {
        $('#showCreateCustomer').click(function () {
            $('#createCustomerModal').modal('show');
        });

        $('#saveCustomerBtn').click(function () {
            const encryptedToken = getCookie('encrypted_token');
            console.log(encryptedToken);
            $.ajax({
                url: '{{ route("customer.store") }}',
                type: 'POST',
                data: $('#createCustomerForm').serialize(),
                headers: {
                    'Authorization': `Bearer ${encryptedToken}`
                },
                success: function(response) {
                    
                    $('#createCustomerModal').modal('hide');
                    updateCustomers();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        $(document).on('click', '.delete-btn', function() {
            const encryptedToken = getCookie('encrypted_token');
            var customerEmail = $(this).data('email');
            var row = $('tr[data-email="' + customerEmail + '"]');
            var deleteUrl = `/customer/${customerEmail}`;

            if (confirm('Are you sure you want to delete this customer?')) {
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    headers: {
                        'Authorization': `Bearer ${encryptedToken}`
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                            alert('Customer deleted successfully.');
                        } else {
                            alert('Failed to delete customer.');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });
        $(document).on('click', '.search-btn', function() {
            const encryptedToken = getCookie('encrypted_token');
            var searchValue = $('#searchInput').val();
            var searchUrl = `customer/${searchValue}`;


            $.ajax({
                url: searchUrl,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}'
                    
                },
                headers: {
                    'Authorization': `Bearer ${encryptedToken}`
                },
                success: function(data) {
                    var customer = data.data;
                    var html = `<table class="table">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>DNI</th>
                                        <th>Region</th>
                                        <th>Commune</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-email="${customer.email}">
                                        <td>${customer.email}</td>
                                        <td>${customer.name}</td>
                                        <td>${customer.last_name}</td>
                                        <td>${customer.address}</td>
                                        <td>${customer.dni}</td>
                                        <td>${customer.id_reg}</td>
                                        <td>${customer.id_com}</td>
                                        <td>
                                            <button class="btn btn-danger delete-btn" data-email="${customer.email}">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>`;
                    $('#customersList').html(html);
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });
        

        function updateCustomers() {
            $.ajax({
                url: '{{ route("customer") }}', 
                type: 'GET',
                success: function(data) {
                    $('#customersList').html($(data).find('#customersList').html());
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }


    });
</script>
@endsection