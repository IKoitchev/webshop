package com.example.webshop.resources;

import com.example.webshop.model.Product;
import com.example.webshop.model.Review;
import com.example.webshop.model.ProductSummary;
import com.example.webshop.payload.response.MessageResponse;
import com.example.webshop.repository.ProductRepository;
import com.example.webshop.repository.ReviewRepository;
import com.fasterxml.jackson.annotation.JsonFormat;
import org.apache.catalina.connector.Response;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;


@RestController
@RequestMapping(value = "/products")
public class ProductResources {

    @Autowired
    ProductRepository productRepository;

    @Autowired
    ReviewRepository reviewRepository;

    @GetMapping(value = "/all")
    public List<Product> getAllProducts() {
        return (List<Product>) productRepository.findAll();
    }

    @GetMapping(value = "/get")
    public Product getProductByName(@RequestParam String name ){

        return productRepository.findByName(name);

    }
    @GetMapping(value = "/ownedBy")
    public List<Product> getOwnedProducts(@RequestParam String name){
        List<Review> reviews = reviewRepository.findAll();
        List<Product> ownedProducts = new ArrayList<>();
        List<Review> ownedReviews = new ArrayList<>();
        for (Review r:reviews) {
            if(r.getAuthor().equals(name)){
                ownedReviews.add(r);
            }
        }
        for(Product p: productRepository.findAll()){
            for(Review r: ownedReviews){
                if(p.getId() == r.getProductId()){
                    ownedProducts.add(p);
                }
            }
        }
        return ownedProducts;
    }
    @GetMapping(value="getStatistics")
    public ProductSummary summary()
    {
        ProductSummary summary = new ProductSummary();
        long id = 0;
        for(Product p: productRepository.findAll()){
            if(id < p.getId())
                id = p.getId();
        }
        Optional<Product> product;

        for(Product p: productRepository.findAll()){
            if(p.getId() == id)
                summary.setNewestProduct(p.getName());
        }

        double totalPrice = 0;
        for(Product p:productRepository.findAll()){
            totalPrice += p.getPrice();
        }

        summary.setAverageProductPrice((double)Math.round(totalPrice / productRepository.findAll().size() ));
        summary.setTotalNumberOfProducts(productRepository.findAll().size());

        return summary;
    }
    @GetMapping(value = "getByGenre")
    public List<Product> getAllByGenre(@RequestParam String genre)
    {
       List<Product> productList = new ArrayList<>();
       for(Product p: productRepository.findAll()){
           if(p.getGenre().equals(genre))
               productList.add(p);
       }
       return productList;
    }

    @PostMapping(value = "/post", consumes = "application/json", produces = "application/json")
    public Product addProduct(@RequestBody Product product){
        if(productRepository.findByName(product.getName()) != null)
            return null;

        productRepository.save(product);
        return product;
    }
    @PutMapping(value = "/update", consumes = "application/json", produces = "application/json")
    public Product updateProduct(@RequestBody Product product){
        if(productRepository.findByName(product.getName()) == null)
            return null;

        productRepository.save(product);
        return product;
    }
    @DeleteMapping(value = "/delete")
    public ResponseEntity<?> deleteProductById(@RequestParam long id){

        if(productRepository.findById(id).isPresent()){
            productRepository.deleteById(id);
            return ResponseEntity
                    .ok()
                    .body(new MessageResponse("Product removed successfully!"));
        }
        return ResponseEntity
                .badRequest()
                .body(new MessageResponse("Error: Product does not exist!"));

    }


}
