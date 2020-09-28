package project.model;

import java.util.ArrayList;
import java.util.List;

public class Product {
    private int id;
    private String description = "game";
    private String name;
    private List<UserReview> reviewList;
    private double price;

    public Product(String name, int id) {
        this.name = name;
        this.id = id;
        reviewList = new ArrayList<UserReview>();
    }

    public Product() {

    }
    public String getName(){
        return this.name;
    }

    public int getId() {
        return this.id;
    }

    public String getInfo(){
        return this.id + ". " + this.name + " - " + this.description;
    }
    public void addUserReview(UserReview review) {
        this.reviewList.add(review);
    }
}
