                         ┌──────────────┐
                         │    USERS     │
                         │ Admin/Owner  │
                         │ Staff Login  │
                         └──────┬───────┘
                                │
                              1 : 1
                                │
                                ▼
                     ┌───────────────────┐
                     │  STAFF_PROFILES   │
                     └─────┬─────┬───────┘
                           │     │
                       1:N │     │ 1:N
                           │     │
             ┌─────────────┘     └──────────────┐
             ▼                                  ▼
    ┌─────────────────┐                ┌─────────────────┐
    │ WORKING_HOURS   │                │  STAFF_DAYS_OFF │
    └─────────────────┘                └─────────────────┘


                     ┌───────────────────┐
                     │     SERVICES      │
                     └─────────┬─────────┘
                               │
                         many : many
                               │
                               ▼
                     ┌───────────────────┐
                     │   SERVICE_STAFF   │
                     │   (pivot table)   │
                     └─────────┬─────────┘
                               │
                               ▼
                     ┌───────────────────┐
                     │  STAFF_PROFILES   │
                     └───────────────────┘


    ┌─────────────────┐
    │    CUSTOMERS    │
    └────────┬────────┘
             │
            1:N
             │
             ▼
    ┌─────────────────────────────────┐
    │             BOOKINGS            │
    │                                 │
    │ customer_id                     │
    │ staff_profile_id                │
    │ service_id                      │
    │ booking_date                    │
    │ start_time                      │
    │ end_time                        │
    │ status                          │
    └─────────────────────────────────┘
             ▲                 ▲
             │                 │
             │                 │
       STAFF_PROFILES        SERVICES
