import { Component, OnInit } from '@angular/core';
import { Course } from '../interfaces/course-interface';
import { RestService } from '../services/_rest/_restservice';
import { catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { CommonModule } from '@angular/common'; // Import CommonModule

@Component({
  selector: 'app-courses',
  standalone: true,
  imports: [CommonModule], // Add CommonModule here

  templateUrl: './courses.component.html',
  styleUrls: ['./courses.component.css']
})
export class CoursesComponent implements OnInit {

  courses: Course[] = []; // Initialize as an empty array
  errorMessage: string = ''; // Variable to hold error message
  isLoading: boolean = false; // Flag to show loading state

  constructor(private restService: RestService) { }

  ngOnInit(): void {
    // Fetch courses when the component initializes
    this.getAllCourses();
  }

  public getAllCourses() {
    this.restService.getCourses().subscribe(
      (response) => {
        // Check if the response contains the array under a property like "data"
        if (response && response.data) {
          this.courses = response.data; // Extract the courses array
        } else {
          console.error('Unexpected API response format:', response);
          this.courses = []; // Fallback to an empty array if the response is not as expected
        }
      },
      (error) => {
        this.errorMessage = 'Failed to fetch courses';
        console.error('Error fetching courses', error);
        this.courses = []; // Fallback to an empty array on error
      }
    );
  }
  
}
