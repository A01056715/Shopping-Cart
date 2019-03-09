@extends('layout')
@section('content')
@if (\Auth::check())
<a href="{{ route('cart') }}">Cart</a>
<a href="{{ route('logout') }}">Logout</a>
@else
<a href="{{ route('login') }}">Login</a>
@endif
<h1>This is the Inventory Page</h1>
<div id='filterSection'>
    <form action="" method="POST" id='filterForm'>
        <h2>Category</h2>
        <input type="checkbox" name="category[]" value="Kitchenware" id='categoryKitchenware' checked/><label for="categoryKitchenware"> Kitchenware</label><br>
        <input type="checkbox" name="category[]" value="Automobile" id='categoryAutomobile' checked><label for="categoryAutomobile"> Automobile</label><br>
        <input type="checkbox" name="category[]" value="Clothing" id='categoryClothing' checked><label for="categoryClothing"> Clothing</label><br>
        <input type="checkbox" name="category[]" value="Computer" id='categoryComputer' checked><label for="categoryComputer"> Computer</label><br>
        <h2>Brand</h2>
        <input type="checkbox" name="brand[]" value="Apple" id='categoryApple' checked/><label for="categoryApple"> Apple</label><br>
        <input type="checkbox" name="brand[]" value="Nike" id='categoryNike' checked><label for="categoryNike"> Nike</label><br>
        <input type="checkbox" name="brand[]" value="KitchenAid" id='categoryKitchenAid' checked><label for="categoryKitchenAid"> Kitchen Aid</label><br>
        <h2>Price Range</h2>
        $<input type="number" placeholder="min" id='priceMin' name='priceMin'/> - <input type="number" placeholder="max" id='priceMax' name='priceMax'/><button id='submitPrice' type='button'>Go</button>
   </form>
</div>
<div id='itemsSection'>
</div>
<script>
    $(document).ready(function() {
        $("body").on('click', '.addToCartButton', function() {
            var modelNumber = $(this).val();
            var quantityID = modelNumber + "Quantity";
            var requestedQuantity = $("#" + quantityID).val();
            $.ajax({
                url: "{{ route('addToCart') }}",
                type:"POST",
                data: {
                    modelNumber: modelNumber,
                    requestedQuantity: requestedQuantity
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    if (response["data"] === "fail")
                    {
                        alert("Failed to add item to cart");
                    }
                    else
                    {
                        alert(response["data"]);
                    }
                },error:function() {
                    alert("Failed to add item");
                }
            });
        });
        
        function sendRequest(index)
        {
            $.ajax({
                url: "{{ route('getItems') }}/" + index,
                type:"POST",
                processData: false,
                contentType: false,
                data: new FormData($('#filterForm')[0]),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    $("#itemsSection").append(response["data"]);
                },error:function() {
                    //alert(data.toString());
                }
            });
        }
        
        $("#submitPrice").click(function() {
            sendRequest();
        })
        
        sendRequest(0);
    });
</script>
@endsection