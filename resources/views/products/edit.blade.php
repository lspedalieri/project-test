<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h2>Edit Product</h2>
                </div>
                <div class="col">
                    <a href="{{route("products.products")}}" wire:navigate class="btn btn-primary btn-sm float-end">Product List</a>
                </div>
            </div>
              
        </div>
        <div class="card-body">
            {{-- here we will show our error or success message --}}
            @if ($is_flash_showing == true)
                <span class="alert alert-success p-2">successfully updated Product.</span>
            @endif
            <form wire:submit="{{route("products.update")}}"> 
                {{-- saveProduct is the function that will save our product to database. let's create this --}}
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" wire:model="product_name" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" value="{{$product->name}}">
                Characters Left:<span x-text="10 - $wire.product_name.length"></span>
                @error('product_name')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <input type="text"  wire:model="description" class="form-control" id="description" name="description" placeholder="Enter product description" value="{{$product->descrption}}">
                @error('description')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Barcode</label>
                <input type="text" wire:model="barcode" class="form-control" id="barcode" name="barcode" placeholder="Enter product name" value="{{$product->barcode}}">
                Characters Left:<span x-text="10 - $wire.barcode.length"></span>
                @error('barcode')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>            
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" wire:model="quantity" class="form-control" id="quantity" name="quantity" placeholder="Enter car Engine quantity" value="{{$product->quantity}}">
                @error('quantity')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            </div>
              <div class="mb-3">
                <label for="restock_time" class="form-label">Restock Time</label>
                <input type="number" wire:model="restock_time" class="form-control" id="restock_time" name="restock_time" placeholder="Enter estimated restock_time" value="{{$product->restock_time}}">
                @error('restock_time')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>            
            <button type="submit" class="btn btn-success">update</button>
            </form>
        </div>
    </div>
</div>