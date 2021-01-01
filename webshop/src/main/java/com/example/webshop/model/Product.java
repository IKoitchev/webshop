package com.example.webshop.model;

import org.springframework.web.bind.annotation.CrossOrigin;

import javax.persistence.*;
import java.util.ArrayList;
import java.util.List;

@CrossOrigin(origins = "http://localhost:8080/products")
@Entity(name = "products")
public class Product {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id")
    private long id;
    @Column(name = "description")
    private String description = "game";
    @Column(name = "name")
    private String name;
    @Column(name = "price")
    private double price = 10.0;
    @Column(name="url")
    private String url;

    public String getUrl() {
        return url;
    }

    public void setUrl(String url) {
        this.url = url;
    }

    public Product() {

    }
    public String getName(){
        return this.name;
    }

    public long getId() {
        return this.id;
    }

    public String getInfo(){
        return this.id + ". " + this.name + " - " + this.description;
    }


    public void setId(long id) {
        this.id = id;
    }

    public double getPrice() {
        return price;
    }

    public void setPrice(double price) {
        this.price = price;
    }

    public void setName(String name) { this.name = name; }

    public void setDescription(String description) {this.description = description;}

    public String getDescription () { return this.description; }
}
