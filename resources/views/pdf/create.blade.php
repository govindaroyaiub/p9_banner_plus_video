@extends('material_ui.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-8 flex align-items-center rounded-lg">
                @include('alert')
                <h3 class="text-xl font-semibold tracking-wide mb-4">Add Billing</h3>
                <br>
                <form id="project-add-form" class="max-w-4xl" method="POST" action="/bills/add"
                    enctype="multipart/form-data" style="width: 100%;">
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
                        <h2 class="text-2xl font-semibold text-center mb-4 text-gray-700">Billing Table</h2>
                
                        <table id="bill_table" class="w-full border border-gray-300 rounded-lg overflow-hidden">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="py-2 px-4">No</th>
                                    <th class="py-2 px-4">Item</th>
                                    <th class="py-2 px-4">Amount</th>
                                    <th class="py-2 px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="text-center">
                                    <td class="py-2 px-4">1</td>
                                    <td class="py-2 px-4">
                                        <input type="text" placeholder="Enter Item Title" name="title[]" 
                                            class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required />
                                    </td>
                                    <td class="py-2 px-4">
                                        <input type="number" placeholder="Enter Item Amount" name="amount[]" 
                                            class="amount w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required />
                                    </td>
                                    <td class="py-2 px-4">
                                        <button class="deleteRow bg-red-500 text-white px-3 py-1 rounded-md cursor-not-allowed opacity-50" disabled>X</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-gray-100 font-semibold">
                                <tr>
                                    <td colspan="2" class="py-2 px-4 text-right">Total Amount:</td>
                                    <td class="py-2 px-4 text-center" id="totalAmount">0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                
                        <button id="addRow" class="mt-4 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                            + Add Item
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
        let markup = `<tr class="text-center">
            <td class="py-2 px-4">${lineNo}</td>
            <td class="py-2 px-4">
                <input type='text' placeholder='Enter Item Title' name='title[]' 
                    class='w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500' required />
            </td>
            <td class="py-2 px-4">
                <input type='number' placeholder='Enter Item Amount' name='amount[]' 
                    class='amount w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500' required />
            </td>
            <td class="py-2 px-4">
                <button class="deleteRow bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition">X</button>
            </td>
        </tr>`;

        $("#bill_table tbody").append(markup);
        lineNo++;
        updateDeleteButtons();
    });

    $(document).on("click", ".deleteRow", function () {
        if ($("#bill_table tbody tr").length > 1) {
            $(this).closest("tr").remove();
            updateRowNumbers();
            updateTotal();
        }
    });

    $(document).on("input", ".amount", function () {
        updateTotal();
    });

    function updateRowNumbers() {
        $("#bill_table tbody tr").each(function (index) {
            $(this).find("td:first").text(index + 1);
        });
        lineNo = $("#bill_table tbody tr").length + 1;
        updateDeleteButtons();
    }

    function updateDeleteButtons() {
        $(".deleteRow").prop("disabled", $("#bill_table tbody tr").length === 1)
            .toggleClass("cursor-not-allowed opacity-50", $("#bill_table tbody tr").length === 1);
    }

    function updateTotal() {
        let total = 0;
        $(".amount").each(function () {
            let value = parseFloat($(this).val()) || 0;
            total += value;
        });
        $("#totalAmount").text(total);
    }
});
    </script>
