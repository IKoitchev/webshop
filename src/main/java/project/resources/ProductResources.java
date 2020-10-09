package project.resources;

import project.model.Product;
import project.repository.FakeDataStore;

import javax.ws.rs.*;
import javax.ws.rs.core.*;
import java.net.URI;
import java.util.List;

@Path("/products")

public class ProductResources {

    public static final FakeDataStore fakeDataStore = new FakeDataStore();
    @Context
    private UriInfo uriInfo;
   // private static final FakeDataStore fakeDataStore = new FakeDataStore();

    @GET
    @Path("/home")
    @Produces(MediaType.APPLICATION_JSON)
    public Response showProducts() {
        List<Product> products = fakeDataStore.getProductList();
        GenericEntity<List<Product>> entity = new GenericEntity<>(products) {  };
        return Response.ok(entity).build();
    }





    @GET
    @Produces(MediaType.APPLICATION_JSON)
    public Response getProductByName(@QueryParam("name") String name) {
        //Product product;
        if (uriInfo.getQueryParameters().containsKey("name")){
            return Response.ok(fakeDataStore.getProductByName(name)).build();
        }
        else{
            return Response.status(Response.Status.BAD_REQUEST).entity("Invalid name.").build();
        }
    }
    @DELETE
    @Path("{id}")
    public Response deleteProduct(@PathParam("id") int id) {
        fakeDataStore.deleteProduct(id);

        return Response.noContent().build();
    }
    @POST
    @Consumes(MediaType.APPLICATION_JSON)
    public Response createProduct(Product product){
        if(!fakeDataStore.addProduct(product)){
            String entity = "product with number " + product.getId() + " already exists";
            return Response.status(Response.Status.CONFLICT).entity(entity).build();
        } else {
            String url = uriInfo.getAbsolutePath() + "?name=" + product.getName();
            URI uri = URI.create(url);
            return Response.created(uri).build();
        }

    }
    @PUT
    @Consumes({MediaType.APPLICATION_FORM_URLENCODED})
    @Path("{id}")
    public Response updateProduct(@PathParam("id") int id,
                                  @FormParam("name") String name,
                                  @FormParam("description") String description ){
        Product product = fakeDataStore.getProductById(id);
        if(product == null){
            return Response.status(Response.Status.NOT_FOUND).entity("Please provide a valid product number.").build();
        }
        product.setName(name);
        product.setDescription(description);

        return Response.noContent().build();
    }


}
