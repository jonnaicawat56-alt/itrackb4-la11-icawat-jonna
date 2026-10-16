Laboratory Activity 9
Your Own Table, Your Own Model

F1. Which column did you make nullable, and why that one and not another?

I made the description column nullable because not all products need a description. I chose this column because the other details, like name, price, stock, and availability, are needed for every product.

F2. Which step failed first for you, and what did the error say?

The first error happened when I tried to add a product before putting $fillable in my Product model. Laravel showed a mass-assignment error because the model did not allow the product details to be added yet.

F3. You changed no Blade file in Part D, yet your pages still work. Why not?

My pages still work because I only changed how the controller gets the product data. Instead of JSON, it now uses Eloquent, and I used toArray() so the data still works with my existing Blade files.