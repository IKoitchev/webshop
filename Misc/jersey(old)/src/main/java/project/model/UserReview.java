package project.model;

public class UserReview {

    private String description;
    private User author;
    private String productName;

    public UserReview(String productName, User author, String description) {
        this.productName = productName;
        this.author = author;
        this.description = description;

    }

    public void UpdateReview(String newDescription){
        this.description = newDescription;
    }
}
