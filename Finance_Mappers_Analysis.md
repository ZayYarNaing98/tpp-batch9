# Finance Domain Infrastructure Mappers Analysis

## Reference: Correct Pattern (DashboardCountsInfrastructureMapper)

**Location:** `app/DMS/Infrastructure/Mappers/DashboardCountsInfrastructureMapper.php`

**Correct Pattern Characteristics:**
- ✅ Uses **static methods** (stateless transformation)
- ✅ Method name: `toDomain()` (consistent naming)
- ✅ Takes **primitive types** as parameters (not Eloquent models)
- ✅ Returns **Domain Entity** directly
- ✅ No dependency on Eloquent models in method signature
- ✅ Clean separation: Infrastructure → Domain conversion

```php
public static function toDomain(
    int $documentCount,
    int $handoverCount,
    int $commissionCount,
    int $cancelProjectCount
): DashboardCounts {
    return new DashboardCounts(...);
}
```

---

## Finance Domain Mappers Analysis

### ❌ **INCORRECT MAPPERS** (9 mappers)

#### 1. **CustomerPaymentMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **instance method** instead of static
- Takes `CustomerPaymentModel` (Eloquent model) directly as parameter
- Creates tight coupling between Infrastructure and Domain layers
- Violates Clean Architecture principle: Domain should not know about Infrastructure

**Current Code:**
```php
public function toDomain(CustomerPaymentModel $model): CustomerPayment
```

**Should be:**
```php
public static function toDomain(
    int $id,
    int $saleReportId,
    int $projectId,
    // ... other primitives
): CustomerPayment
```

**Why it's wrong:**
- Domain layer becomes aware of Eloquent models
- Makes testing harder (requires Eloquent models)
- Violates dependency inversion principle
- Repository should extract data from model first, then pass to mapper

---

#### 2. **CustomerDebitMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **instance method** instead of static
- Takes `CustomerDebitModel` (Eloquent model) directly
- Same architectural violations as CustomerPaymentMapper

**Current Code:**
```php
public function toDomain(CustomerDebitModel $model): CustomerDebit
```

---

#### 3. **SupplierDebitMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **instance method** instead of static
- Takes `SupplierDebitModel` (Eloquent model) directly
- Same architectural violations

**Current Code:**
```php
public function toDomain(SupplierDebitModel $model): SupplierDebit
```

---

#### 4. **SupplierCostingMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **instance method** instead of static
- Takes `SupplierCostingModel` (Eloquent model) directly
- Contains complex business logic (discount calculation) that should be in domain
- Accesses nested relationships directly (`$model->project->user->customer->BillingAddress`)

**Current Code:**
```php
public function toDomain(SupplierCostingModel $model): SupplierCosting
```

**Additional Issues:**
- Business logic in mapper (lines 87-95): discount calculation should be in domain entity
- Deep navigation of Eloquent relationships violates encapsulation

---

#### 5. **SupplierCreditMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **instance method** instead of static
- Takes `SupplierCreditModel` (Eloquent model) directly
- Same architectural violations

**Current Code:**
```php
public function toDomain(SupplierCreditModel $model): SupplierCredit
```

---

#### 6. **CustomerCreditMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **instance method** instead of static
- Takes `CustomerCreditModel` (Eloquent model) directly
- Missing `declare(strict_types=1);` (inconsistent with others)
- Same architectural violations

**Current Code:**
```php
public function toDomain(CustomerCreditModel $model): CustomerCredit
```

---

#### 7. **VendorMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromModel()` instead of `toDomain()`
- Takes `VendorModel` (Eloquent model) directly
- Inconsistent naming convention

**Current Code:**
```php
public static function fromModel(VendorModel $model): Vendor
```

**Should be:**
```php
public static function toDomain(
    int $id,
    string $vendorName,
    // ... other primitives
): Vendor
```

---

#### 8. **VendorCategoryMapper**
**Status:** ❌ **WRONG** (Partially)

**Issues:**
- Uses **instance method** for `toDomain()` instead of static
- Takes `VendorCategoryModel` (Eloquent model) directly
- Has legacy static method `fromModel()` for backwards compatibility (inconsistent)

**Current Code:**
```php
public function toDomain(VendorCategoryModel $model): VendorCategory
public static function fromModel(VendorCategoryModel $model): VendorCategory
```

**Note:** This mapper is closest to correct pattern but still wrong because:
- Should be static
- Should take primitives, not Eloquent model

---

#### 9. **AdvancePaymentMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **instance method** instead of static
- Takes `AdvancePaymentModel` (Eloquent model) directly
- Accesses nested relationship (`$model->user`) directly

**Current Code:**
```php
public function toDomain(AdvancePaymentModel $model): AdvancePayment
```

---

#### 10. **SaleReportMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromModel()` instead of `toDomain()`
- Takes Eloquent model directly (type hint missing, uses `$saleReport`)
- Has additional method `fromCollection()` that also takes Eloquent collection
- Deep navigation of Eloquent relationships
- Returns array in `fromCollection()` instead of domain collection

**Current Code:**
```php
public static function fromModel($saleReport): SaleReport
public static function fromCollection($collection): array
```

**Multiple Issues:**
1. Wrong method naming (`fromModel` vs `toDomain`)
2. Missing type hints (loose typing)
3. Takes Eloquent models directly
4. `fromCollection()` returns array instead of domain collection
5. Complex nested relationship navigation

---

## Summary

### ✅ **CORRECT MAPPERS:** 0 out of 10

### ❌ **INCORRECT MAPPERS:** 10 out of 10

---

## Common Violations Across All Mappers

### 1. **Dependency Violation**
All mappers take Eloquent models directly, creating dependency from Infrastructure → Domain on Eloquent framework.

**Impact:**
- Domain layer becomes aware of Infrastructure concerns
- Violates Clean Architecture dependency rule (inner layers should not depend on outer layers)
- Makes unit testing difficult (requires Eloquent setup)

### 2. **Method Type Violation**
Most mappers use instance methods instead of static methods.

**Impact:**
- Unnecessary object instantiation
- Mappers are stateless transformations - should be static
- Inconsistent with correct pattern

### 3. **Naming Inconsistency**
Some mappers use `fromModel()` instead of `toDomain()`.

**Impact:**
- Inconsistent API across codebase
- Confusing naming (should indicate direction: Infrastructure → Domain)

### 4. **Deep Relationship Navigation**
Many mappers navigate deep Eloquent relationships (e.g., `$model->project->user->customer->BillingAddress`).

**Impact:**
- Tight coupling to Eloquent relationship structure
- Fragile code (breaks if relationship changes)
- Should extract data in repository first, then pass to mapper

### 5. **Business Logic in Mappers**
Some mappers contain business logic (e.g., discount calculation in SupplierCostingMapper).

**Impact:**
- Business logic should be in domain entities, not infrastructure mappers
- Violates Single Responsibility Principle

---

## Recommended Fix Pattern

### Current (Wrong):
```php
class CustomerPaymentMapper
{
    public function toDomain(CustomerPaymentModel $model): CustomerPayment
    {
        // Direct access to Eloquent model
        return new CustomerPayment(
            id: new ID($model->id),
            amount: new Amount($model->amount),
            // ...
        );
    }
}
```

### Correct Pattern:
```php
class CustomerPaymentMapper
{
    public static function toDomain(
        int $id,
        int $saleReportId,
        int $projectId,
        float $amount,
        string $description,
        // ... other primitives
    ): CustomerPayment {
        return new CustomerPayment(
            id: new ID($id),
            saleReportId: new ID($saleReportId),
            projectId: new ID($projectId),
            amount: new Amount($amount),
            description: $description,
            // ...
        );
    }
}
```

### Repository Usage (Correct):
```php
class CustomerPaymentRepositoryImpl
{
    public function findById(int $id): CustomerPayment
    {
        $model = CustomerPaymentModel::with([...])->findOrFail($id);
        
        // Extract data from model first
        return CustomerPaymentMapper::toDomain(
            id: $model->id,
            saleReportId: $model->sale_report_id,
            projectId: $model->project_id,
            amount: $model->amount,
            // ... extract all needed data
        );
    }
}
```

---

## Clean Architecture / DDD Principles Violated

1. **Dependency Rule Violation:** Domain depends on Infrastructure (via Eloquent models)
2. **Separation of Concerns:** Infrastructure concerns leak into Domain layer
3. **Testability:** Hard to test domain logic without Eloquent setup
4. **Framework Independence:** Domain is coupled to Laravel/Eloquent
5. **Single Responsibility:** Mappers doing more than just transformation

---

## Conclusion

**All 10 Finance Infrastructure mappers need to be refactored** to follow the correct pattern demonstrated by `DashboardCountsInfrastructureMapper`. The main changes required are:

1. Convert instance methods to static methods
2. Change method signatures to accept primitives instead of Eloquent models
3. Standardize method naming to `toDomain()`
4. Move data extraction logic to repositories
5. Remove business logic from mappers
6. Avoid deep relationship navigation in mappers

