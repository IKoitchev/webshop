import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.testng.annotations.Test;

import java.net.URISyntaxException;
import java.util.concurrent.TimeUnit;

public class SeleniumTest {
    public static void main(String[] args) {

        WebDriverManager.firefoxdriver().setup();
        WebDriver driver = new FirefoxDriver();
        String startUrl = "http://localhost:3000/login";
        String expectedURL = "http://localhost:3000/profile";


            driver.get(startUrl);

            driver.findElement(By.id("username")).sendKeys("johny");

            driver.findElement(By.id("password")).sendKeys("123456");

            driver.findElement(By.id("loginbtn")).click();


            if(driver.getCurrentUrl().equals(expectedURL))
                System.out.println("Success");
                //driver.quit();


    }
}
