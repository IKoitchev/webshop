package com.example.webshop.resources;

import com.example.webshop.model.Review;
import com.example.webshop.repository.ReviewRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping(value = "/reviews")
public class ReviewResources {


    @Autowired
    ReviewRepository reviewRepository;

    @GetMapping(value="/get")
    public List<Review> getReviewByProductId(@RequestParam long productId){
        List<Review> allReviews = reviewRepository.findAll();
        List<Review> matchingId = new ArrayList<>();
        for(int i = 0; i<allReviews.size();i++){
            if(allReviews.get(i).getProductId() == productId){
                matchingId.add(allReviews.get(i));
            }
        }
        return matchingId;
    }
    @PostMapping(value="/post", consumes = "application/json", produces = "application/json")
    public Review createReview(@RequestBody Review review){
        reviewRepository.save(review);
        return review;
    }
    @PutMapping(value="/update", consumes = "application/json", produces = "application/json" )
    public Review updateReview(@RequestBody Review review){
        reviewRepository.save(review);
        return review;
    }
    @DeleteMapping(value="/delete")
    public void deleteReview(@RequestParam long id){
        reviewRepository.deleteById(id);
    }
}
