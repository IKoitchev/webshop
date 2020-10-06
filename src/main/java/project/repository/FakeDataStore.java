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
    public boolean deleteProduct(int id ){
        for (Product product : productList){
            if (product.getId() == id) {
                productList.remove(product);
                return true;
            }
        }
        return false;
    }
    public boolean addProduct(Product product ){
        if (this.getProductById(product.getId()) != null){
            return false;
        }
        productList.add(product);
        return true;
    }
    public boolean updateProduct(Product product) {
        Product old = this.getProductById(product.getId());
        if (old == null) {
            return false;
        }
        old.setName(product.getName());
        old.setDescription(product.getDescription());
        return true;
    }
}
