package project.repository;

import project.model.Product;
import project.model.User;

import java.util.ArrayList;
import java.util.List;

public class FakeDataStore {

    private final List<Product> productList = new ArrayList<>();
    private final List<User> userList = new ArrayList<User>() ;

    public FakeDataStore() {
        Product product1 = new Product("among us", 11251);
        Product product2 = new Product("fortnite", 170549275);
        Product product3 = new Product("cs:go", 99887654);

        productList.add(product1);
        productList.add(product2);
        productList.add(product3);

    }
}
