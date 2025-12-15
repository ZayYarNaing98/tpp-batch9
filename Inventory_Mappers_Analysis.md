# Inventory Domain Infrastructure Mappers Analysis

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

## Inventory Domain Mappers Analysis

### ❌ **INCORRECT MAPPERS** (8 mappers)

#### 1. **DuctMaterialMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromModel()` instead of `toDomain()`
- Takes `DuctMaterialModel` (Eloquent model) directly
- Returns **array** instead of Domain Entity ❌
- Violates Clean Architecture: Should return domain entity, not array

**Current Code:**
```php
public static function fromModel(DuctMaterialModel $model): array
{
    return [
        'id' => $model->id,
        'name' => $model->name,
        // ... returns array
    ];
}
```

**Why it's wrong:**
- Returns array instead of domain entity
- Domain layer should work with entities, not arrays
- Takes Eloquent model directly (dependency violation)
- Wrong method naming convention

---

#### 2. **AirconMaterialMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromCategoryModel()` instead of `toDomain()`
- Takes `AirconMaterialCategoryModel` (Eloquent model) directly
- Returns **array** instead of Domain Entity ❌
- Contains complex transformation logic with nested relationships

**Current Code:**
```php
public static function fromCategoryModel(AirconMaterialCategoryModel $category): array
{
    // Complex nested transformations
    $materials = $category->materials->map(function ($material) {
        // ...
    })->toArray();
    
    return [
        'category' => [...],
        'metadataOptions' => [...],
        'materials' => $materials
    ];
}
```

**Why it's wrong:**
- Returns array instead of domain entity
- Takes Eloquent model directly
- Wrong method naming
- Complex nested relationship navigation

---

#### 3. **InventoryItemMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromModel()` instead of `toDomain()`
- Takes `InventoryItemModel` (Eloquent model) directly
- Has `toModel()` method that contains persistence logic ❌
- `toModel()` method queries database (`InventoryItemModel::find()`) - should be in repository

**Current Code:**
```php
public static function fromModel(InventoryItemModel $model): InventoryItemEntity
{
    return new InventoryItemEntity(...);
}

public static function toModel(InventoryItemEntity $entity): InventoryItemModel
{
    $model = $entity->id ? InventoryItemModel::find($entity->id) : new InventoryItemModel();
    // ... persistence logic
    return $model;
}
```

**Why it's wrong:**
- Takes Eloquent model directly in `fromModel()`
- `toModel()` method violates Single Responsibility:
  - Should be named `toPersistence()` and return array
  - Should NOT query database (that's repository's job)
  - Should NOT create/find models (that's repository's job)

**Should be:**
```php
public static function toDomain(
    int $id,
    string $assetNo,
    // ... primitives
): InventoryItemEntity

public static function toPersistence(InventoryItemEntity $entity): array
{
    return [
        'id' => $entity->id,
        'asset_no' => $entity->assetNo,
        // ... return array for repository to use
    ];
}
```

---

#### 4. **StoreRoomMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromModel()` instead of `toDomain()`
- Takes `StoreRoomModel` (Eloquent model) directly
- Has `toModel()` method that contains persistence logic ❌
- `toModel()` queries database - should be in repository

**Current Code:**
```php
public static function fromModel(StoreRoomModel $model): StoreRoomEntity
{
    return new StoreRoomEntity(...);
}

public static function toModel(StoreRoomEntity $entity): StoreRoomModel
{
    $model = $entity->id ? StoreRoomModel::find($entity->id) : new StoreRoomModel();
    // ... persistence logic
    return $model;
}
```

**Same issues as InventoryItemMapper**

---

#### 5. **WarehouseMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromModel()` instead of `toDomain()`
- Takes `WarehouseModel` (Eloquent model) directly
- Has `toModel()` method that contains **extensive persistence logic** ❌
- `toModel()` method:
  - Queries database (`WarehouseModel::find()`, `AddressModel::find()`)
  - Creates/updates `AddressModel` directly
  - Contains logging statements
  - Should be in repository layer

**Current Code:**
```php
public static function fromModel(WarehouseModel $model): WarehouseEntity
{
    // Accesses nested relationship
    if ($model->address) {
        $address = new Address(...);
    }
    return new WarehouseEntity(...);
}

public static function toModel(WarehouseEntity $entity): WarehouseModel
{
    $model = $entity->id ? WarehouseModel::find($entity->id) : new WarehouseModel();
    
    // ❌ WRONG: Persistence logic in mapper
    if ($entity->address) {
        if ($entity->address->addressId) {
            $addressModel = AddressModel::find($entity->address->addressId);
        } else {
            $addressModel = new AddressModel();
        }
        $addressModel->fill([...]);
        $addressModel->save(); // ❌ Mapper should NOT save
        $addressId = $addressModel->id;
    }
    
    return $model;
}
```

**Why it's wrong:**
- Takes Eloquent model directly
- `toModel()` contains extensive persistence logic (saving addresses)
- Mapper should only transform, not persist
- Logging statements in mapper (should be in repository/service)
- Deep relationship navigation

---

#### 6. **StockTakeMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromModel()` instead of `toDomain()`
- Takes `StockTakeModel` (Eloquent model) directly
- Has `toModel()` method that contains persistence logic ❌
- `toModel()` queries database - should be in repository

**Current Code:**
```php
public static function fromModel(StockTakeModel $model): StockTakeEntity
{
    return new StockTakeEntity(...);
}

public static function toModel(StockTakeEntity $entity): StockTakeModel
{
    $model = $entity->id ? StockTakeModel::find($entity->id) : new StockTakeModel();
    // ... persistence logic
    return $model;
}
```

**Same issues as InventoryItemMapper**

---

#### 7. **InventoryItemCategoryMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromModel()` instead of `toDomain()`
- Takes `InventoryItemCategoryModel` (Eloquent model) directly
- Has `toModel()` method that contains persistence logic ❌
- `toModel()` queries database - should be in repository

**Current Code:**
```php
public static function fromModel(InventoryItemCategoryModel $model): InventoryItemCategoryEntity
{
    return new InventoryItemCategoryEntity(...);
}

public static function toModel(InventoryItemCategoryEntity $entity): InventoryItemCategoryModel
{
    $model = $entity->id ? InventoryItemCategoryModel::find($entity->id) : new InventoryItemCategoryModel();
    // ... persistence logic
    return $model;
}
```

**Same issues as InventoryItemMapper**

---

#### 8. **StockMovementMapper**
**Status:** ❌ **WRONG**

**Issues:**
- Uses **static method** ✅ (good)
- BUT uses wrong method name: `fromModel()` instead of `toDomain()`
- Takes `StockMovementModel` (Eloquent model) directly
- Has `toModel()` method that contains persistence logic ❌
- `toModel()` queries database - should be in repository

**Current Code:**
```php
public static function fromModel(StockMovementModel $model): StockMovementEntity
{
    return new StockMovementEntity(...);
}

public static function toModel(StockMovementEntity $entity): StockMovementModel
{
    $model = $entity->id ? StockMovementModel::find($entity->id) : new StockMovementModel();
    // ... persistence logic
    return $model;
}
```

**Same issues as InventoryItemMapper**

---

## Summary

### ✅ **CORRECT MAPPERS:** 0 out of 8

### ❌ **INCORRECT MAPPERS:** 8 out of 8

---

## Common Violations Across All Mappers

### 1. **Dependency Violation**
All mappers take Eloquent models directly, creating dependency from Infrastructure → Domain on Eloquent framework.

**Impact:**
- Domain layer becomes aware of Infrastructure concerns
- Violates Clean Architecture dependency rule
- Makes unit testing difficult

### 2. **Wrong Method Naming**
All mappers use `fromModel()` instead of `toDomain()`.

**Impact:**
- Inconsistent with correct pattern
- Confusing naming (should indicate direction: Infrastructure → Domain)

### 3. **Return Type Violations**
Some mappers (`DuctMaterialMapper`, `AirconMaterialMapper`) return arrays instead of domain entities.

**Impact:**
- Domain layer should work with entities, not arrays
- Breaks encapsulation
- Makes domain logic harder to implement

### 4. **Persistence Logic in Mappers**
Many mappers have `toModel()` methods that:
- Query the database (`Model::find()`)
- Create new model instances
- Should be in repository layer

**Impact:**
- Violates Single Responsibility Principle
- Mappers should only transform, not persist
- Makes testing harder
- Creates tight coupling

### 5. **Deep Relationship Navigation**
Some mappers navigate Eloquent relationships directly (e.g., `$model->address`, `$model->category->materials`).

**Impact:**
- Tight coupling to Eloquent relationship structure
- Fragile code
- Should extract data in repository first

### 6. **Business Logic in Mappers**
`WarehouseMapper::toModel()` contains extensive persistence logic including:
- Address creation/updates
- Logging statements
- Complex conditional logic

**Impact:**
- Should be in repository or service layer
- Mappers should be pure transformations

---

## Recommended Fix Pattern

### Current (Wrong):
```php
class InventoryItemMapper
{
    public static function fromModel(InventoryItemModel $model): InventoryItemEntity
    {
        return new InventoryItemEntity(
            id: $model->id,
            assetNo: $model->asset_no,
            // ...
        );
    }
    
    public static function toModel(InventoryItemEntity $entity): InventoryItemModel
    {
        $model = $entity->id ? InventoryItemModel::find($entity->id) : new InventoryItemModel();
        $model->asset_no = $entity->assetNo;
        // ...
        return $model;
    }
}
```

### Correct Pattern:
```php
class InventoryItemMapper
{
    public static function toDomain(
        int $id,
        string $assetNo,
        string $partNumber,
        ?string $tagId,
        string $name,
        ?string $brand,
        ?string $model,
        ?int $categoryId,
        ?int $warehouseId,
        ?int $storeRoomId,
        float $quantityOnHand,
        float $minimumStockLevel,
        float $price,
        string $status,
        string $dateOfPurchase,
        ?string $alternativePartNumber,
        string $createdAt,
        string $updatedAt
    ): InventoryItemEntity {
        return new InventoryItemEntity(
            id: $id,
            assetNo: $assetNo,
            partNumber: $partNumber,
            tagId: $tagId,
            name: $name,
            brand: $brand,
            model: $model,
            categoryId: $categoryId,
            warehouseId: $warehouseId,
            storeRoomId: $storeRoomId,
            quantityOnHand: $quantityOnHand,
            minimumStockLevel: $minimumStockLevel,
            price: new Amount($price),
            status: $status,
            dateOfPurchase: new DateTimeImmutable($dateOfPurchase),
            alternativePartNumber: $alternativePartNumber,
            createdAt: new DateTimeImmutable($createdAt),
            updatedAt: new DateTimeImmutable($updatedAt),
        );
    }
    
    public static function toPersistence(InventoryItemEntity $entity): array
    {
        return [
            'id' => $entity->id,
            'asset_no' => $entity->assetNo,
            'part_number' => $entity->partNumber,
            'tag_id' => $entity->tagId,
            'name' => $entity->name,
            'brand' => $entity->brand,
            'model' => $entity->model,
            'category_id' => $entity->categoryId,
            'warehouse_id' => $entity->warehouseId,
            'store_room_id' => $entity->storeRoomId,
            'quantity_on_hand' => $entity->quantityOnHand,
            'minimum_stock_level' => $entity->minimumStockLevel,
            'price' => $entity->price->toFloat(),
            'status' => $entity->status,
            'date_of_purchase' => $entity->dateOfPurchase->format('Y-m-d'),
            'alternative_part_number' => $entity->alternativePartNumber,
        ];
    }
}
```

### Repository Usage (Correct):
```php
class InventoryItemRepositoryImpl
{
    public function findById(int $id): ?InventoryItemEntity
    {
        $model = InventoryItemModel::with(['category', 'warehouse', 'storeRoom'])->find($id);
        
        if (!$model) {
            return null;
        }
        
        // Extract data from model first
        return InventoryItemMapper::toDomain(
            id: $model->id,
            assetNo: $model->asset_no,
            partNumber: $model->part_number,
            // ... extract all needed data
            createdAt: $model->created_at->format('Y-m-d H:i:s'),
            updatedAt: $model->updated_at->format('Y-m-d H:i:s'),
        );
    }
    
    public function save(InventoryItemEntity $entity): int
    {
        $data = InventoryItemMapper::toPersistence($entity);
        
        $model = $entity->id 
            ? InventoryItemModel::findOrFail($entity->id)
            : new InventoryItemModel();
            
        $model->fill($data);
        $model->save();
        
        return $model->id;
    }
}
```

---

## Special Cases

### DuctMaterialMapper & AirconMaterialMapper
These mappers return arrays instead of domain entities. They need:
1. Domain entities created for `DuctMaterial` and `AirconMaterial`
2. Mappers should return these entities, not arrays
3. If arrays are needed for API responses, create separate Application layer mappers (like `DashboardCountsMapper`)

---

## Clean Architecture / DDD Principles Violated

1. **Dependency Rule Violation:** Domain depends on Infrastructure (via Eloquent models)
2. **Separation of Concerns:** Infrastructure concerns leak into Domain layer
3. **Single Responsibility:** Mappers doing persistence (should only transform)
4. **Testability:** Hard to test domain logic without Eloquent setup
5. **Framework Independence:** Domain is coupled to Laravel/Eloquent
6. **Return Type Violations:** Some return arrays instead of domain entities

---

## Conclusion

**All 8 Inventory Infrastructure mappers need to be refactored** to follow the correct pattern demonstrated by `DashboardCountsInfrastructureMapper`. The main changes required are:

1. Convert `fromModel()` to `toDomain()` with primitive parameters
2. Change method signatures to accept primitives instead of Eloquent models
3. Remove `toModel()` methods or convert to `toPersistence()` that returns arrays
4. Move persistence logic (database queries, model creation) to repositories
5. Create domain entities for `DuctMaterial` and `AirconMaterial` (currently return arrays)
6. Avoid deep relationship navigation in mappers

