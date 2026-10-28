Laboratory Activity 11
Finish Your Own CRUD

G1.Route model binding needs two things to be true. Name both, and say what happens when only one of them is? 
Route model binding needs two things: the parameter must be type-hinted with the model class (`Product $product`), and the parameter name must match the route segment (`{product}`, so `$product`). If only the type-hint is right and the name is wrong, no record is bound, so the controller gets nothing it can use. If only the name is right and the type-hint is missing, the controller receives the raw id from the URL and not a Product model.

G2.Your Delete link gave a 404 even though the address was correct. Explain why?
My Delete link did not return a 404. The address `/products/1` was correct, but a link sends a GET request, and `GET products/{product}` is handled by the `show` route, so the detail page was displayed instead. The `destroy` route only answers DELETE, which is why the Delete button uses a form with `@method('DELETE')`.

G3.old() takes a second argument on your edit form. What would break if you left it out, and what would break if you used only it?
The second argument is the record's current value, which fills the field when the form is first opened. If I left it out, the edit form would show empty fields on first load because there is nothing for `old()` to fall back on. If I used only `old()` with no fallback, a rejected submit would keep what I typed, but the form would still start empty, and no value would appear on first load.
