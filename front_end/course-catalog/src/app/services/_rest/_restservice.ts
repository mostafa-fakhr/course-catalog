import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root',
})
export class RestService {

  private apiUrl: string = environment.apiUrl;

  constructor(private http: HttpClient) {}

  // Method to get courses
  getCourses(): Observable<any> {
    const url = `${this.apiUrl}/courses`; 
    console.log(url);
    return this.http.get<any>(url);
  }
}
