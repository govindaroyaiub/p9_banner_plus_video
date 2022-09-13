@extends('layouts.app')

@section('content')
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

</style>
<div class="container mx-auto px-4">
    <div class="flex -mx-4">
        @include('sidebar')
        <div class="w-3/5 mx-4">
            @include('alert')
            <h3 class="text-xl font-semibold tracking-wide mb-4">Add Billing</h3>
            <br>
            <form id="project-add-form" class="max-w-xl" method="POST" action="/bills/add"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="text-primary font-light block">Billing Title</label>
                    <input type='text' placeholder="Enter Billings Title" name="project_name"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <div class="mb-4">
                    <label class="text-primary font-light block">Billing Date</label>
                    <input type='datetime-local' name="created_at"
                        class="w-full mt-2 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                        required />
                </div>

                <input type="hidden" name="logo_id" id="logo_id" value="{{ Auth::user()->company_id }}">
                <input type="hidden" name="color" id="color" value="#4b4e6d">
                <input type="hidden" name="client_name" id="client_name" value="PLANETNINE">

                <table id="bill_table" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th data-priority="1">No</th>
                            <th data-priority="2">Item</th>
                            <th data-priority="3">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="text-align: center;">
                            <td>1</td>
                            <td>
                                <input type='text' placeholder="Enter Item Title" name="title[]"
                                    class="w-full mt-2 px-4 py-4 mb-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                                    required />
                            </td>
                            <td>
                                <input type='number' placeholder="Enter Item Amount" name="amount[]"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" 
                                    class="w-full mt-2 px-4 py-4 mb-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary"
                                    required />
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" id="addRow"
                    class="w-full mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-2 focus:outline-none">
                    +
                </button>

                <div class="flex space-x-4 mt-4">
                    <button type="submit"
                        class="w-full mt-2 mb-6 bg-blue-600 text-gray-200 text-lg rounded hover:bg-blue-500 px-6 py-2 focus:outline-none">
                        CREATE
                    </button>
                    <button type="button" onclick="window.history.back()"
                        class="w-full mt-2 mb-6 bg-red-600 text-gray-100 text-lg rounded hover:bg-red-500 px-6 py-2 focus:outline-none">
                        BACK
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection



    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.25.0/axios.min.js"
        integrity="sha512-/Q6t3CASm04EliI1QyIDAA/nDo9R8FQ/BULoUFyN4n/BDdyIxeH7u++Z+eobdmr11gG5D/6nPFyDlnisDwhpYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        let lineNo = 2;
        $(document).ready(function () {
            $("#addRow").click(function () {
                markup = "<tr style='text-align: center;'><td>" +
                    lineNo + "</td><td>" + "<input type='text' placeholder='Enter Item Title' name='title[]'  class='w-full mt-2 px-4 py-4 mb-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary' required />" +"</td><td>" + '<input type="number" placeholder="Enter Item Amount" name="amount[]" class="w-full mt-2 px-4 py-4 mb-2 border rounded-lg text-gray-700 focus:outline-none focus:border-primary" required />' + "</td></tr>";
                tableBody = $("#bill_table");
                tableBody.append(markup);
                lineNo++;
            });
        });
    </script>
