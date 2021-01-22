package com.example.webshop.model;


import org.springframework.web.bind.annotation.CrossOrigin;

import javax.persistence.*;
import java.util.Date;
import java.util.List;

@CrossOrigin(origins = "http://localhost:8080/reviews")
@Entity(name = "reviews")
public class Review {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id")
    private long id;
    @Column(name = "text")
    private String text = "";
    @Column(name = "author")
    private String author;
    @Column(name = "product_id")
    private long productId;
    @Column(name="date_posted")
    private Date datePosted ;


    public Review() { }

    public Review(String author, long productId){

        this.author = author;
        this.productId = productId;
    }
    public Review(String author, long productId, String text){

        this.author = author;
        this.productId = productId;
        this.text = text;
    }

    public String getAuthor() {
        return author;
    }

    public void setAuthor(String author) {
        this.author = author;
    }

    public long getProductId() {
        return productId;
    }

    public void setProductId(long productId) {
        this.productId = productId;
    }

    public long getId() {
        return id;
    }

    public void setId(long id) {
        this.id = id;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public Date getDatePosted() {
        return datePosted;
    }

    public void setDatePosted(Date datePosted) {
        this.datePosted = datePosted;
    }
}
