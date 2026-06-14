# OneBasket - Product Requirements Document (PRD)

## Product Vision

OneBasket is a hyperlocal commerce and fulfillment platform that enables customers to purchase products from multiple local vendors through a single shopping experience and receive all items in one consolidated delivery.

The platform acts as the operational layer between customers, vendors, pickup agents, fulfillment centers, and delivery agents.

Unlike traditional marketplaces, OneBasket manages the complete order fulfillment lifecycle including vendor coordination, pickup operations, consolidation, packing, dispatch, tracking, and delivery.

---

## Core Value Proposition

### For Customers

- Shop from multiple local stores
- Single cart
- Single checkout
- Single order
- Single package
- Single delivery

### For Vendors

- Access additional customers
- No delivery management required
- No logistics coordination required
- Simple product and inventory management

### For Operations Team

- Centralized fulfillment workflow
- Pickup management
- Packing workflow
- Delivery management
- Real-time tracking

---

## Business Workflow

Customer Places Order
↓
Single Parent Order Created
↓
Vendor Fulfillment Records Generated
↓
Inventory Reserved
↓
Pickup Tasks Created
↓
Pickup Agents Collect Products
↓
Products Arrive At Fulfillment Hub
↓
Products Verified
↓
Products Packed Into Single Package
↓
Delivery Assigned
↓
Customer Receives Consolidated Order

The customer must only interact with a single order throughout the lifecycle.

---

## User Roles

### Super Admin

Responsibilities:
- Platform configuration
- Vendor management
- User management
- Fulfillment hub management
- Operations oversight
- Analytics and reporting

### Operations Manager

Responsibilities:
- Monitor pickups
- Monitor packing
- Monitor deliveries
- Handle exceptions
- Manage agents

### Vendor

Responsibilities:
- Manage products
- Manage inventory
- Receive fulfillment requests
- Prepare products for pickup

### Customer

Responsibilities:
- Browse products
- Search products
- Place orders
- Track orders
- Manage account

### Pickup Agent

Responsibilities:
- View assigned pickup tasks
- Visit vendors
- Collect products
- Confirm collection
- Report issues

### Packing Staff

Responsibilities:
- Receive collected items
- Verify items
- Pack orders
- Generate shipment

### Delivery Agent

Responsibilities:
- View assigned deliveries
- Deliver packages
- Upload delivery proof
- Complete delivery

---

## MVP Goal

Validate the complete fulfillment workflow where products from multiple vendors can be consolidated into a single package and delivered through one delivery process.

---

## Module 1 - Authentication & Authorization

Features:
- Login
- Registration
- Password reset
- Email verification
- Role-based permissions
- Session management

Requirements:
- Secure authentication
- Granular role permissions
- Activity tracking

---

## Module 2 - Vendor Management

Features:
- Vendor onboarding
- Vendor approval workflow
- Vendor profile management
- Vendor status management

Vendor Information:
- Business name
- Contact information
- Address
- Operating hours
- Pickup availability

Vendor Statuses:
- Pending
- Active
- Suspended
- Inactive

---

## Module 3 - Product Catalog

Features:
- Product management
- Categories
- Product images
- Product search
- Product filtering

Product Information:
- Name
- Description
- Price
- Inventory quantity
- Vendor association
- Product status

Product Statuses:
- Active
- Draft
- Out Of Stock
- Disabled

---

## Module 4 - Inventory Management

Purpose:
Maintain accurate stock information across vendors.

Features:
- Inventory tracking
- Stock reservation
- Stock adjustments
- Inventory alerts

Requirements:
- Inventory must be reserved during checkout.
- Inventory must be released when orders are cancelled.
- Inventory updates must be reflected in real time.

---

## Module 5 - Customer Shopping Experience

Features:
- Product browsing
- Product search
- Cart management
- Checkout
- Order history
- Profile management

Requirements:
- Customers can purchase products from multiple vendors in one cart.
- Checkout must produce a single customer-facing order.

---

## Module 6 - Unified Order Management

Requirements:

The platform must maintain a single customer-facing order regardless of the number of vendors involved.

When products belong to multiple vendors, the system must automatically generate vendor-specific fulfillment records linked to the parent order.

These records are internal operational entities used for inventory allocation, vendor preparation, pickup coordination, and fulfillment tracking.

Customers must only see a single order throughout the entire lifecycle.

The platform must automatically calculate overall order progress based on the status of all fulfillment records.

---

## Module 7 - Vendor Fulfillment Workflow

Features:
- Vendor fulfillment requests
- Vendor preparation status
- Vendor readiness confirmation

Statuses:
- Awaiting Confirmation
- Confirmed
- Preparing
- Ready For Pickup
- Collected

Requirements:
- Vendors must indicate when products are ready for collection.

---

## Module 8 - Pickup Management

Purpose:
Coordinate collection of products from vendors.

Features:
- Pickup task generation
- Pickup assignment
- Pickup route planning
- Pickup verification

Pickup Statuses:
- Pending
- Assigned
- En Route
- At Vendor
- Collected
- Delivered To Hub

Requirements:
- Pickup agents must be able to collect products from multiple vendors during a single pickup run.

---

## Module 9 - Fulfillment Hub Operations

Purpose:
Centralize and consolidate products.

Features:
- Incoming item verification
- Consolidation management
- Packing queue
- Shipment preparation

Requirements:
- The system must verify that all required items have been received before packing begins.

---

## Module 10 - Packing Workflow

Features:
- Packing queue
- Item verification
- Package generation
- Shipment preparation

Packing Statuses:
- Pending
- In Progress
- Awaiting Items
- Packed
- Ready For Dispatch

Requirements:
- All products belonging to a customer order must be consolidated into one package whenever possible.

---

## Module 11 - Delivery Management

Features:
- Delivery assignment
- Delivery scheduling
- Delivery tracking
- Delivery completion

Delivery Statuses:
- Pending
- Assigned
- Out For Delivery
- Delivered
- Failed

Requirements:
- Each consolidated package should generate a single delivery workflow.

---

## Module 12 - Proof Of Delivery

Features:
- Delivery photo
- Customer signature
- Delivery notes
- Delivery timestamp

Requirements:
- Every completed delivery must have proof attached.

---

## Module 13 - GPS Tracking

Features:
- Agent location tracking
- Delivery tracking
- Real-time location updates

Requirements:
- Pickup agents should be trackable.
- Delivery agents should be trackable.
- Operations team should be able to monitor active routes.

---

## Module 14 - Customer Tracking Portal

Features:
- Order tracking
- Fulfillment progress
- Delivery status
- Estimated arrival time

Requirements:
- Customers must be able to track the complete journey from order placement to delivery.

---

## Module 15 - Notifications

Phase 1:
- Email notifications

Events:
- Order placed
- Order confirmed
- Ready for delivery
- Out for delivery
- Delivered
- Order issue detected

Future:
- SMS
- WhatsApp
- Push notifications

---

## Module 16 - Operations Dashboard

Features:
- Active orders
- Active pickups
- Active deliveries
- Delayed orders
- Fulfillment bottlenecks

Purpose:
Provide operational visibility across the entire fulfillment pipeline.

---

## Module 17 - Reporting & Analytics

Reports:
- Order volume
- Vendor performance
- Fulfillment efficiency
- Pickup performance
- Delivery performance
- Revenue reports

---

## Mobile Applications

### Pickup Agent App

Features:
- Assigned pickups
- Vendor navigation
- Pickup confirmation
- Issue reporting

### Delivery Agent App

Features:
- Assigned deliveries
- GPS tracking
- Proof of delivery
- Delivery completion

---

## Future Roadmap (Not MVP)

- Vendor self-registration
- Vendor subscription plans
- Payment gateway integrations
- Route optimization
- AI demand forecasting
- Multi-city operations
- Multiple fulfillment hubs
- Warehouse management
- Returns management
- Customer mobile application
- Shopify integration
- WooCommerce integration
- CS-Cart integration

---

## Success Criteria

1. Customers can buy from multiple vendors in one cart.
2. Customers receive one consolidated order experience.
3. Products are automatically coordinated across vendors.
4. Pickup operations are fully managed.
5. Orders are consolidated into one package.
6. Deliveries are completed through a single workflow.
7. Customers can track the complete fulfillment lifecycle from purchase to delivery.

OneBasket is not a traditional marketplace. It is a fulfillment-first commerce platform focused on consolidating products from multiple local vendors into a single customer order, package, and delivery experience.
