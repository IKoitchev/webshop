package project.repository;

import project.model.Product;
import project.model.User;

import java.util.ArrayList;
import java.util.List;

public class FakeDataStore {

    private final List<Product> productList = new ArrayList<Product>();
    private final List<User> userList = new ArrayList<User>() ;

    public FakeDataStore() {
        Product product1 = new Product("amongus", 1);
        Product product2 = new Product("fortnite", 2);
        Product product3 = new Product("csgo", 3);

        productList.add(product1);
        productList.add(product2);
        productList.add(product3);

    }


    public Product getProductByName(String name)
    {
        for(Product product : productList) {
            if(product.getName().equals(name))
                return product;
        }
        return null;
    }
    public Product getProductById(int id)
    {
        for(Product product : productList){
            if (product.getId() == id)
                return product;
        }
        return null;
    }

    public List<Product> getProductList() {
        return productList;
    }
}
