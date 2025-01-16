<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h2>Laravel 11.x + Livewire 3.x CRUD</h2>
                </div>
                <div class="col">
                    <a href="{{route("products.products")}}" wire:navigate class="btn btn-primary btn-sm float-end">Car List</a>
                </div>
            </div>
              
        </div>
        <div class="card-body">
            <form wire:submit="{{route("products.store")}}"> 
                {{-- saveProduct is the function that will save our products to database. let's create this --}}
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" wire:model="product_name" class="form-control" id="product_name" name="product_name" placeholder="Enter product name">
                @error('product_name')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product description</label>
                <input type="text"  wire:model="description" class="form-control" id="description" name="description" placeholder="Enter product description">
                @error('description')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product barcode</label>
                <input type="text"  wire:model="barcode" class="form-control" id="barcode" name="barcode" placeholder="Enter product barcode">
                @error('barcode')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>            
            <div class="mb-3">
                <label for="quantity" class="form-label">Product Warehouse Quantity</label>
                <input type="number" wire:model="quantity" class="form-control" id="quantity" name="quantity" placeholder="Enter product warehouse quantity">
                @error('quantity')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="restock_time" class="form-label">Product Estimated Restock Time</label>
                <input type="number" wire:model="restock_time" class="form-control" id="restock_time" name="restock_time" placeholder="Enter product warehouse restock_time">
                @error('restock_time')
                    {{-- here we show validation error --}}
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>            
            <button type="submit" class="btn btn-success">Save</button>

            </form>
        </div>
    </div>
</div>