# Student Status vs Application Status

## Why both exist

| | **Student status** | **Application status** |
|--|--------------------|--------------------------|
| **What it describes** | The **person’s** overall stage in the pipeline (one value per student). | The **individual application** to a university (one value per application). |
| **Scope** | One student = one status at a time. | One student can have many applications, each with its own status. |
| **Used for** | Lists, dashboards, filters, “who can do visa” (e.g. visa create shows students with status `accepted` or `visa_processing`). | Per-application workflow: draft → submitted → under_review → accepted/rejected → enrolled. |

## Student status (pipeline)

Typical flow:  
`inquiry` → `registered` → `applied` → `accepted` → `visa_processing` → `visa_approved` → `departed`  
(plus: `visa_rejected`, `enrolled`, `completed`, `cancelled`, etc.)

- Set to **applied** when at least one application is created.
- Set to **accepted** when at least one application becomes accepted/enrolled (so they can proceed to visa).
- Updated by visa flow: **visa_processing**, **visa_approved**, **visa_rejected**, **departed**.

## Application status (per application)

Per application:  
`draft` → `documents_preparing` → `documents_ready` → `submitted` → `under_review` → `interview_scheduled` → `interview_completed` → **accepted** / **rejected** / **waitlisted** → **enrolled** / **withdrawn**

- One student can have: Application A = accepted, Application B = rejected, Application C = under_review.
- Application status is **needed** to track each university application separately.

## Summary

- **Student status** = “Where is this student in our overall process?” (one value per student).  
- **Application status** = “What is the state of this specific application?” (one value per application).  
Both are needed; they answer different questions. Student status is kept in sync when applications are created or when an application becomes accepted/enrolled (so the student can move to visa, reports, etc.).
