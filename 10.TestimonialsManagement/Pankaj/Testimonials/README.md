Magento 2 Testimonial Module - Summary

1️ Module Setup
    - Created module directory: app/code/Pankaj/Testimonials/
    - Registered module in registration.php and module.xml


2️ Database Setup
    - Created pankaj_testimonials table in db_schema.xml


3️ Model, Resource Model & Collection

    - Created Model/Testimonials.php
    - Created Model/ResourceModel/Testimonials.php
    - Created Model/ResourceModel/Testimonials/Collection.php


4️ API Endpoints (REST API - webapi.xml)

    - Get Testimonial by ID - /V1/testimonial/:testimonialId
    - Get Testimonial List - /V1/testimonial/list
    - Create Testimonial - /V1/testimonial (POST)
    - Delete Testimonial - /V1/testimonial/:testimonialId (DELETE)

5️ API Interface & Repository
    - Api/TestimonialRepositoryInterface.php (Defines methods)
    - Model/TestimonialRepository.php (Implements interface)


6️ Implemented CRUD Operations
    - getById($id) - Fetch single testimonial
    - list($searchCriteria) - Fetch multiple testimonials
    - save($testimonial) - Save new testimonial
    - delete($testimonialId) - Delete testimonial
    - mass delete
    - Mass update status 


7 Frontend: Testimonial Slider
    - Added testimonials.phtml for displaying testimonials
    - Included Slick Slider JS & CSS for carousel effect


8 CSV File Imported Using CLI Command:

    - Place testimonials.csv in:
        app/code/Pankaj/Testimonials/import/testimonials.csv
    - CSV File Format:
        Columns: company_name, name, message, post, status, profile_pic
    - Run Import Command:
        php bin/magento testimonials:import


9 Uninstall Module
    - Dropped Pankaj_testimonials table in Uninstall.php
    - Removed module using php bin/magento module:uninstall
