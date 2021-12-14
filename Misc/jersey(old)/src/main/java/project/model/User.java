package project.model;

public class User {
    private int id;
    private String email;
    private String name;
    private static int idSeeder = 1;

    public User(String email, String name) {
        this.email = email;
        this.name = name;
        this.id = idSeeder;
        idSeeder++;
    }
}
