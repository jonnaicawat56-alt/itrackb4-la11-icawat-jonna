Laboratory Activity 10
Your Own Lookup Table

G1. Which column did you turn into a table, and why that one and not another?

I used the category_id column in the products table to connect each product to its category in the categories table. I chose this because each product belongs to one category, and one category can have many products. This also makes it easier to show the category name on the products list.

G2. What number did screenshot 6 show, and why exactly that number?

Screenshot 6 showed 6 queries because the system used one query to get all the products and five more queries to get the category of each product separately. So, that’s one query for the products plus five queries for the categories. This happens because the categories are loaded one by one instead of all at once.

G3. Your belongsTo method is named in the singular. What would break if you made it plural?

I used category() in the singular because each product belongs to only one category. If I changed it to categories() without updating the other code, with('category') and $product->category would stop working because Laravel would not find the relationship using the old name.