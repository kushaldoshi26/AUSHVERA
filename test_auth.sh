#!/bin/bash

# AUSHVERA Authentication API Testing Script
# This script tests all authentication and cart endpoints

BASE_URL="http://127.0.0.1:8000/api"
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}================================${NC}"
echo -e "${YELLOW}AUSHVERA API Test Suite${NC}"
echo -e "${YELLOW}================================${NC}\n"

# Test 1: Register User
echo -e "${YELLOW}[TEST 1]${NC} User Registration"
echo "POST /api/register"
REGISTER_RESPONSE=$(curl -s -X POST "$BASE_URL/register" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "1234567890",
    "city": "New York"
  }')

echo "$REGISTER_RESPONSE" | jq '.' 2>/dev/null || echo "$REGISTER_RESPONSE"

TOKEN=$(echo "$REGISTER_RESPONSE" | jq -r '.data.token' 2>/dev/null)
USER_ID=$(echo "$REGISTER_RESPONSE" | jq -r '.data.user.id' 2>/dev/null)

if [ "$TOKEN" != "null" ] && [ ! -z "$TOKEN" ]; then
    echo -e "${GREEN}✓ Registration successful${NC}"
    echo -e "  Token: ${YELLOW}$TOKEN${NC}"
    echo -e "  User ID: ${YELLOW}$USER_ID${NC}\n"
else
    echo -e "${RED}✗ Registration failed${NC}\n"
    exit 1
fi

# Test 2: Get Current User
echo -e "${YELLOW}[TEST 2]${NC} Get Current User"
echo "GET /api/user"
USER_RESPONSE=$(curl -s -X GET "$BASE_URL/user" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json")

echo "$USER_RESPONSE" | jq '.' 2>/dev/null || echo "$USER_RESPONSE"

if echo "$USER_RESPONSE" | jq '.success' | grep -q "true"; then
    echo -e "${GREEN}✓ Current user fetched${NC}\n"
else
    echo -e "${RED}✗ Failed to fetch current user${NC}\n"
fi

# Test 3: Get Cart
echo -e "${YELLOW}[TEST 3]${NC} Get Cart"
echo "GET /api/cart"
CART_RESPONSE=$(curl -s -X GET "$BASE_URL/cart" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json")

echo "$CART_RESPONSE" | jq '.' 2>/dev/null || echo "$CART_RESPONSE"

if echo "$CART_RESPONSE" | jq '.success' | grep -q "true"; then
    echo -e "${GREEN}✓ Cart fetched successfully${NC}\n"
else
    echo -e "${RED}✗ Failed to fetch cart${NC}\n"
fi

# Test 4: Get Products (to add to cart)
echo -e "${YELLOW}[TEST 4]${NC} Get Products"
echo "GET /api/products"
PRODUCTS_RESPONSE=$(curl -s -X GET "$BASE_URL/products" \
  -H "Content-Type: application/json")

echo "$PRODUCTS_RESPONSE" | jq '.data | length' 2>/dev/null || echo "$PRODUCTS_RESPONSE"

PRODUCT_ID=$(echo "$PRODUCTS_RESPONSE" | jq -r '.data[0].id' 2>/dev/null)

if [ "$PRODUCT_ID" != "null" ] && [ ! -z "$PRODUCT_ID" ]; then
    echo -e "${GREEN}✓ Products fetched${NC}"
    echo -e "  Product ID: ${YELLOW}$PRODUCT_ID${NC}\n"
else
    echo -e "${YELLOW}⚠ No products available - need to seed database first${NC}\n"
    PRODUCT_ID=1  # Use default for testing
fi

# Test 5: Add Item to Cart
echo -e "${YELLOW}[TEST 5]${NC} Add Item to Cart"
echo "POST /api/cart/add"
ADD_ITEM_RESPONSE=$(curl -s -X POST "$BASE_URL/cart/add" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d "{
    \"product_id\": $PRODUCT_ID,
    \"quantity\": 2
  }")

echo "$ADD_ITEM_RESPONSE" | jq '.' 2>/dev/null || echo "$ADD_ITEM_RESPONSE"

if echo "$ADD_ITEM_RESPONSE" | jq '.success' | grep -q "true"; then
    echo -e "${GREEN}✓ Item added to cart${NC}\n"
    CART_ITEM_ID=$(echo "$ADD_ITEM_RESPONSE" | jq -r '.data.id' 2>/dev/null)
else
    echo -e "${YELLOW}⚠ Could not add item (product may not exist)${NC}\n"
fi

# Test 6: Get Cart Count
echo -e "${YELLOW}[TEST 6]${NC} Get Cart Count"
echo "GET /api/cart/count"
CART_COUNT_RESPONSE=$(curl -s -X GET "$BASE_URL/cart/count" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json")

echo "$CART_COUNT_RESPONSE" | jq '.' 2>/dev/null || echo "$CART_COUNT_RESPONSE"

if echo "$CART_COUNT_RESPONSE" | jq '.success' | grep -q "true"; then
    CART_COUNT=$(echo "$CART_COUNT_RESPONSE" | jq -r '.data.count' 2>/dev/null)
    echo -e "${GREEN}✓ Cart count: ${YELLOW}$CART_COUNT${NC}\n"
else
    echo -e "${YELLOW}⚠ Could not get cart count${NC}\n"
fi

# Test 7: Login (test with different user)
echo -e "${YELLOW}[TEST 7]${NC} User Login"
echo "POST /api/login"
LOGIN_RESPONSE=$(curl -s -X POST "$BASE_URL/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }')

echo "$LOGIN_RESPONSE" | jq '.' 2>/dev/null || echo "$LOGIN_RESPONSE"

LOGIN_TOKEN=$(echo "$LOGIN_RESPONSE" | jq -r '.data.token' 2>/dev/null)

if [ "$LOGIN_TOKEN" != "null" ] && [ ! -z "$LOGIN_TOKEN" ]; then
    echo -e "${GREEN}✓ Login successful${NC}\n"
else
    echo -e "${RED}✗ Login failed${NC}\n"
fi

# Test 8: Logout
echo -e "${YELLOW}[TEST 8]${NC} User Logout"
echo "POST /api/logout"
LOGOUT_RESPONSE=$(curl -s -X POST "$BASE_URL/logout" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json")

echo "$LOGOUT_RESPONSE" | jq '.' 2>/dev/null || echo "$LOGOUT_RESPONSE"

if echo "$LOGOUT_RESPONSE" | jq '.success' | grep -q "true"; then
    echo -e "${GREEN}✓ Logout successful${NC}\n"
else
    echo -e "${RED}✗ Logout failed${NC}\n"
fi

# Test 9: Try to access protected route after logout
echo -e "${YELLOW}[TEST 9]${NC} Access Protected Route After Logout (Should Fail)"
echo "GET /api/user"
AFTER_LOGOUT=$(curl -s -X GET "$BASE_URL/user" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json")

echo "$AFTER_LOGOUT" | jq '.' 2>/dev/null || echo "$AFTER_LOGOUT"

if echo "$AFTER_LOGOUT" | jq '.' | grep -q "Unauthenticated"; then
    echo -e "${GREEN}✓ Correctly denied access (expected behavior)${NC}\n"
else
    echo -e "${YELLOW}⚠ Unexpected response${NC}\n"
fi

echo -e "${YELLOW}================================${NC}"
echo -e "${GREEN}Test Suite Complete!${NC}"
echo -e "${YELLOW}================================${NC}"
