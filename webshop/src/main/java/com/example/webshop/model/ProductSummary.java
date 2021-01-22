package com.example.webshop.model;

import java.util.Optional;

public class ProductSummary {

    private int totalNumberOfProducts;
    //private String mostPopularProduct;
   // private String mostPoplarGenre;
    private double averageProductPrice;
    private String newestProduct;

    public ProductSummary() {
    }

    public ProductSummary(int totalNumberOfProducts, String mostPopularProduct, String mostPoplarGenre, double averageProductPrice) {
        this.totalNumberOfProducts = totalNumberOfProducts;
       // this.mostPopularProduct = mostPopularProduct;
       // this.mostPoplarGenre = mostPoplarGenre;
        this.averageProductPrice = averageProductPrice;
    }


    public String getNewestProduct() {
        return newestProduct;
    }

    public void setNewestProduct(String newestProduct) {
        this.newestProduct = newestProduct;
    }

    public int getTotalNumberOfProducts() {
        return totalNumberOfProducts;
    }

    public void setTotalNumberOfProducts(int totalNumberOfProducts) {
        this.totalNumberOfProducts = totalNumberOfProducts;
    }

   /* public String getMostPopularProduct() {
        return mostPopularProduct;
    }

    public void setMostPopularProduct(String mostPopularProduct) {
        this.mostPopularProduct = mostPopularProduct;
    }

    public String getMostPoplarGenre() {
        return mostPoplarGenre;
    }

    public void setMostPoplarGenre(String mostPoplarGenre) {
        this.mostPoplarGenre = mostPoplarGenre;
    }*/

    public double getAverageProductPrice() {
        return averageProductPrice;
    }

    public void setAverageProductPrice(double averageProductPrice) {
        this.averageProductPrice = averageProductPrice;
    }
}
