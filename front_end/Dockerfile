# Use the Node.js base image
FROM node:18

# Set the working directory inside the container
WORKDIR /app

# Install Angular CLI globally
RUN npm install -g @angular/cli

# Skip prompt questions
ENV NG_CLI_ANALYTICS=false

# Copy the package.json and package-lock.json first to leverage Docker's cache
COPY front_end/course-catalog/package*.json ./

# Install project dependencies
RUN npm install

# Copy the rest of the Angular project files into the container
COPY front_end/course-catalog/ ./

# Expose port 4200 for the Angular development server
EXPOSE 4200

# Start the Angular development server
CMD ["ng", "serve", "--host", "0.0.0.0", "--port", "4200"]

