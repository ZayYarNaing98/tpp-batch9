# Inventory Domain Infrastructure Mappers - Quick Summary

## Reference Pattern: DashboardCountsInfrastructureMapper ✅
- Static method `toDomain()`
- Takes primitives as parameters
- Returns Domain Entity
- No Eloquent model dependencies

---

## Inventory Mappers Status

| # | Mapper Name | Status | Main Issues |
|---|-------------|--------|-------------|
| 1 | DuctMaterialMapper | ❌ WRONG | Wrong method name (`fromModel`), takes Eloquent model, **returns array** |
| 2 | AirconMaterialMapper | ❌ WRONG | Wrong method name (`fromCategoryModel`), takes Eloquent model, **returns array** |
| 3 | InventoryItemMapper | ❌ WRONG | Wrong method name (`fromModel`), takes Eloquent model, has `toModel()` with persistence logic |
| 4 | StoreRoomMapper | ❌ WRONG | Wrong method name (`fromModel`), takes Eloquent model, has `toModel()` with persistence logic |
| 5 | WarehouseMapper | ❌ WRONG | Wrong method name (`fromModel`), takes Eloquent model, has `toModel()` with **extensive persistence logic** |
| 6 | StockTakeMapper | ❌ WRONG | Wrong method name (`fromModel`), takes Eloquent model, has `toModel()` with persistence logic |
| 7 | InventoryItemCategoryMapper | ❌ WRONG | Wrong method name (`fromModel`), takes Eloquent model, has `toModel()` with persistence logic |
| 8 | StockMovementMapper | ❌ WRONG | Wrong method name (`fromModel`), takes Eloquent model, has `toModel()` with persistence logic |

---

## Summary

**✅ Correct Mappers: 0 / 8**  
**❌ Incorrect Mappers: 8 / 8**

---

## Common Issues

1. **All mappers take Eloquent models directly** → Violates Clean Architecture dependency rule
2. **Wrong method naming** → All use `fromModel()` instead of `toDomain()`
3. **Return type violations** → `DuctMaterialMapper` and `AirconMaterialMapper` return arrays instead of domain entities
4. **Persistence logic in mappers** → `toModel()` methods query database and create models (should be in repository)
5. **Deep relationship navigation** → Some navigate Eloquent relationships directly

---

## Critical Issues

### 🚨 **Most Severe: WarehouseMapper**
- Contains extensive persistence logic in `toModel()` method
- Creates/updates `AddressModel` directly
- Contains logging statements
- Should be completely refactored

### 🚨 **Return Type Violations**
- `DuctMaterialMapper` and `AirconMaterialMapper` return arrays
- Need domain entities created for these
- Arrays should only be in Application layer (DTOs)

### 🚨 **Persistence Logic in Mappers**
- All mappers with `toModel()` methods contain database queries
- `InventoryItemMapper::toModel()` calls `InventoryItemModel::find()`
- `WarehouseMapper::toModel()` calls `AddressModel::find()` and `save()`
- This logic belongs in repositories

---

## What Needs to Change

For each mapper:
- ✅ Convert `fromModel()` to static `toDomain()` with primitive parameters
- ✅ Remove `toModel()` or convert to `toPersistence()` that returns array
- ✅ Move all database queries to repository layer
- ✅ Move persistence logic to repository layer
- ✅ Create domain entities for `DuctMaterial` and `AirconMaterial`
- ✅ Remove logging statements from mappers

---

## Comparison with Finance Mappers

| Aspect | Finance Mappers | Inventory Mappers |
|--------|----------------|-------------------|
| Method Type | Instance methods | Static methods ✅ |
| Method Naming | `toDomain()` (correct name) | `fromModel()` (wrong name) |
| Return Type | Domain entities ✅ | Arrays (2 mappers) ❌ |
| Persistence Logic | `toPersistence()` returns array ✅ | `toModel()` queries DB ❌ |
| Overall Pattern | Closer to correct | Further from correct |

**Note:** While Inventory mappers use static methods (better than Finance), they have more severe issues:
- Persistence logic in mappers
- Database queries in mappers
- Return type violations

