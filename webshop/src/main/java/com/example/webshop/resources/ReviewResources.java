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
            if(allReviews.get(i).getProductId() == productId
                    && allReviews.get(i).getText() != null
                    && !allReviews.get(i).getText().isEmpty()){
                matchingId.add(allReviews.get(i));
            }
        }
        return matchingId;
    }

    @GetMapping(value = "/owned")
    public boolean isOwned(@RequestParam long productId, String authorName)
    {
        List<Review> allReviews = reviewRepository.findAll();
        for(Review r:allReviews)
        {
            if(r.getProductId() == productId && authorName.equals(r.getAuthor())){
                return true;
            }
        }
        return false;
    }
    @PostMapping(value="/buyProduct", consumes = "application/json", produces = "application/json")
    public Review buyProduct(@RequestBody Review review){
        reviewRepository.save(review);
        return review;
    }
    @PutMapping(value="/update", consumes = "application/json", produces = "application/json" )
    public Review addReview(@RequestBody Review review){
        List<Review> allReviews = reviewRepository.findAll();
        Review searchedReview = new Review();
        for(Review r: allReviews){
            if(r.getProductId() == review.getProductId() && r.getAuthor().equals(review.getAuthor())){
                searchedReview = r;
            }
        }
        searchedReview.setText(review.getText());

        reviewRepository.save(searchedReview);
        return searchedReview;
    }
    @DeleteMapping(value="/delete")
    public void deleteReview(@RequestParam long id){
        reviewRepository.deleteById(id);
    }
}
